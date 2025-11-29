import { Response, NextFunction } from 'express';
import { User } from '../models/User.js';
import { Billing } from '../models/Billing.js';
import { AppError, asyncHandler } from '../middleware/errorHandler.js';
import { AuthRequest } from '../middleware/auth.js';

export const getProfile = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const user = await User.findById(req.user._id);
  const billing = await Billing.findOne({ userId: req.user._id });

  res.json({
    status: 'success',
    data: { user, billing }
  });
});

export const updateProfile = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const { name, email } = req.body;

  if (email && email !== req.user.email) {
    const existingUser = await User.findOne({ email });
    if (existingUser) {
      throw new AppError('Email already in use', 400);
    }
  }

  const user = await User.findByIdAndUpdate(
    req.user._id,
    { name, email },
    { new: true, runValidators: true }
  );

  res.json({
    status: 'success',
    data: { user }
  });
});

export const changePassword = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const { currentPassword, newPassword } = req.body;

  const user = await User.findById(req.user._id).select('+password');
  if (!user) {
    throw new AppError('User not found', 404);
  }

  const isMatch = await user.comparePassword(currentPassword);
  if (!isMatch) {
    throw new AppError('Current password is incorrect', 400);
  }

  user.password = newPassword;
  await user.save();

  res.json({
    status: 'success',
    message: 'Password updated successfully'
  });
});
