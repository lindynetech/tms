import { Response, NextFunction } from 'express';
import { Goal } from '../models/Goal.js';
import { Task } from '../models/Task.js';
import { AppError, asyncHandler } from '../middleware/errorHandler.js';
import { AuthRequest } from '../middleware/auth.js';

export const getGoals = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const goals = await Goal.find({ userId: req.user._id }).sort({ deadline: 1 });

  res.json({
    status: 'success',
    data: { goals }
  });
});

export const getGoal = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const goal = await Goal.findOne({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!goal) {
    throw new AppError('Goal not found', 404);
  }

  const tasks = await Task.find({ goalId: goal._id }).sort({ duedate: 1 });

  res.json({
    status: 'success',
    data: { goal, tasks }
  });
});

export const createGoal = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const goalData = {
    ...req.body,
    userId: req.user._id
  };

  const goal = await Goal.create(goalData);

  res.status(201).json({
    status: 'success',
    data: { goal }
  });
});

export const updateGoal = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const goal = await Goal.findOneAndUpdate(
    { _id: req.params.id, userId: req.user._id },
    req.body,
    { new: true, runValidators: true }
  );

  if (!goal) {
    throw new AppError('Goal not found', 404);
  }

  res.json({
    status: 'success',
    data: { goal }
  });
});

export const deleteGoal = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const goal = await Goal.findOneAndDelete({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!goal) {
    throw new AppError('Goal not found', 404);
  }

  await Task.deleteMany({ goalId: goal._id });

  res.json({
    status: 'success',
    message: 'Goal deleted successfully'
  });
});
