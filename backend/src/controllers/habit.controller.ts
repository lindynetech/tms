import { Response, NextFunction } from 'express';
import { Habit, HabitDay } from '../models/Habit.js';
import { AppError, asyncHandler } from '../middleware/errorHandler.js';
import { AuthRequest } from '../middleware/auth.js';

export const getHabits = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const habits = await Habit.find({ userId: req.user._id }).sort({ createdAt: -1 });

  res.json({
    status: 'success',
    data: { habits }
  });
});

export const getHabit = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const habit = await Habit.findOne({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!habit) {
    throw new AppError('Habit not found', 404);
  }

  const days = await HabitDay.find({ habitId: habit._id }).sort({ date: -1 }).limit(30);

  res.json({
    status: 'success',
    data: { habit, days }
  });
});

export const createHabit = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const habitData = {
    ...req.body,
    userId: req.user._id
  };

  const habit = await Habit.create(habitData);

  res.status(201).json({
    status: 'success',
    data: { habit }
  });
});

export const updateHabit = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const habit = await Habit.findOneAndUpdate(
    { _id: req.params.id, userId: req.user._id },
    req.body,
    { new: true, runValidators: true }
  );

  if (!habit) {
    throw new AppError('Habit not found', 404);
  }

  res.json({
    status: 'success',
    data: { habit }
  });
});

export const deleteHabit = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const habit = await Habit.findOneAndDelete({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!habit) {
    throw new AppError('Habit not found', 404);
  }

  await HabitDay.deleteMany({ habitId: habit._id });

  res.json({
    status: 'success',
    message: 'Habit deleted successfully'
  });
});

export const trackHabit = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const { habitId } = req.params;
  const { date, completed, notes } = req.body;

  const habit = await Habit.findOne({ _id: habitId, userId: req.user._id });
  if (!habit) {
    throw new AppError('Habit not found', 404);
  }

  const habitDay = await HabitDay.findOneAndUpdate(
    { habitId, date: new Date(date) },
    { completed, notes },
    { new: true, upsert: true, runValidators: true }
  );

  if (completed) {
    habit.streak += 1;
    if (habit.streak > habit.longestStreak) {
      habit.longestStreak = habit.streak;
    }
  } else {
    habit.streak = 0;
  }
  await habit.save();

  res.json({
    status: 'success',
    data: { habitDay, habit }
  });
});

export const resetHabit = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const habit = await Habit.findOne({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!habit) {
    throw new AppError('Habit not found', 404);
  }

  habit.streak = 0;
  await habit.save();

  res.json({
    status: 'success',
    data: { habit }
  });
});
