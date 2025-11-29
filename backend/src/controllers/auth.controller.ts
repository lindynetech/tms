import { Request, Response, NextFunction } from 'express';
import jwt, { Secret } from 'jsonwebtoken';
import { User } from '../models/User.js';
import { Billing } from '../models/Billing.js';
import { config } from '../config/app.js';
import { AppError, asyncHandler } from '../middleware/errorHandler.js';
import { AuthRequest } from '../middleware/auth.js';

const generateToken = (userId: string): string => {
  // @ts-ignore - JWT type definitions issue
  return jwt.sign({ userId }, config.jwt.secret, {
    expiresIn: config.jwt.expiresIn
  });
};

const generateRefreshToken = (userId: string): string => {
  // @ts-ignore - JWT type definitions issue
  return jwt.sign({ userId }, config.jwt.refreshSecret, {
    expiresIn: config.jwt.refreshExpiresIn
  });
};

export const register = asyncHandler(async (req: Request, res: Response, next: NextFunction) => {
  const { name, email, password } = req.body;

  const existingUser = await User.findOne({ email });
  if (existingUser) {
    throw new AppError('Email already registered', 400);
  }

  const user = await User.create({
    name,
    email,
    password
  });

  await Billing.create({
    userId: user._id,
    status: 'Free Trial'
  });

  const token = generateToken(user._id.toString());
  const refreshToken = generateRefreshToken(user._id.toString());

  res.status(201).json({
    status: 'success',
    data: {
      user: {
        id: user._id,
        name: user.name,
        email: user.email
      },
      token,
      refreshToken
    }
  });
});

export const login = asyncHandler(async (req: Request, res: Response, next: NextFunction) => {
  const { email, password } = req.body;

  if (!email || !password) {
    throw new AppError('Please provide email and password', 400);
  }

  const user = await User.findOne({ email }).select('+password');
  if (!user || !(await user.comparePassword(password))) {
    throw new AppError('Invalid email or password', 401);
  }

  const token = generateToken(user._id.toString());
  const refreshToken = generateRefreshToken(user._id.toString());

  res.json({
    status: 'success',
    data: {
      user: {
        id: user._id,
        name: user.name,
        email: user.email
      },
      token,
      refreshToken
    }
  });
});

export const logout = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  res.json({
    status: 'success',
    message: 'Logged out successfully'
  });
});

export const getCurrentUser = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const user = await User.findById(req.user._id);

  res.json({
    status: 'success',
    data: { user }
  });
});

export const refreshToken = asyncHandler(async (req: Request, res: Response, next: NextFunction) => {
  const { refreshToken } = req.body;

  if (!refreshToken) {
    throw new AppError('Refresh token required', 400);
  }

  const decoded = jwt.verify(refreshToken, config.jwt.refreshSecret as Secret) as { userId: string };

  const user = await User.findById(decoded.userId);
  if (!user) {
    throw new AppError('User not found', 404);
  }

  const newToken = generateToken(user._id.toString());
  const newRefreshToken = generateRefreshToken(user._id.toString());

  res.json({
    status: 'success',
    data: {
      token: newToken,
      refreshToken: newRefreshToken
    }
  });
});
