import { Response, NextFunction } from 'express';
import { DailyGoal } from '../models/DailyGoal.js';
import { AppError, asyncHandler } from '../middleware/errorHandler.js';
import { AuthRequest } from '../middleware/auth.js';

export const getDailyGoals = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const dailyGoals = await DailyGoal.find({ userId: req.user._id }).sort({ deadline: 1 });

  res.json({
    status: 'success',
    data: { dailyGoals }
  });
});

export const createDailyGoal = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const goalData = {
    ...req.body,
    userId: req.user._id
  };

  const dailyGoal = await DailyGoal.create(goalData);

  res.status(201).json({
    status: 'success',
    data: { dailyGoal }
  });
});

export const updateDailyGoal = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const dailyGoal = await DailyGoal.findOneAndUpdate(
    { _id: req.params.id, userId: req.user._id },
    req.body,
    { new: true, runValidators: true }
  );

  if (!dailyGoal) {
    throw new AppError('Daily goal not found', 404);
  }

  res.json({
    status: 'success',
    data: { dailyGoal }
  });
});

export const deleteDailyGoal = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const dailyGoal = await DailyGoal.findOneAndDelete({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!dailyGoal) {
    throw new AppError('Daily goal not found', 404);
  }

  res.json({
    status: 'success',
    message: 'Daily goal deleted successfully'
  });
});

export const flushDailyGoals = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  await DailyGoal.deleteMany({ userId: req.user._id });

  res.json({
    status: 'success',
    message: 'All daily goals cleared'
  });
});
