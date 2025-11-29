import { Response, NextFunction } from 'express';
import { Task } from '../models/Task.js';
import { Subtask } from '../models/Subtask.js';
import { Goal } from '../models/Goal.js';
import { AppError, asyncHandler } from '../middleware/errorHandler.js';
import { AuthRequest } from '../middleware/auth.js';

export const getTasks = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const { goalId } = req.params;

  const goal = await Goal.findOne({ _id: goalId, userId: req.user._id });
  if (!goal) {
    throw new AppError('Goal not found', 404);
  }

  const tasks = await Task.find({ goalId }).sort({ duedate: 1 });

  res.json({
    status: 'success',
    data: { tasks }
  });
});

export const getTask = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const task = await Task.findById(req.params.id);

  if (!task) {
    throw new AppError('Task not found', 404);
  }

  const goal = await Goal.findOne({ _id: task.goalId, userId: req.user._id });
  if (!goal) {
    throw new AppError('Unauthorized', 403);
  }

  const subtasks = await Subtask.find({ taskId: task._id });

  res.json({
    status: 'success',
    data: { task, subtasks }
  });
});

export const createTask = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const { goalId } = req.params;

  const goal = await Goal.findOne({ _id: goalId, userId: req.user._id });
  if (!goal) {
    throw new AppError('Goal not found', 404);
  }

  const taskData = {
    ...req.body,
    goalId
  };

  const task = await Task.create(taskData);

  res.status(201).json({
    status: 'success',
    data: { task }
  });
});

export const updateTask = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const task = await Task.findById(req.params.id);

  if (!task) {
    throw new AppError('Task not found', 404);
  }

  const goal = await Goal.findOne({ _id: task.goalId, userId: req.user._id });
  if (!goal) {
    throw new AppError('Unauthorized', 403);
  }

  Object.assign(task, req.body);
  await task.save();

  res.json({
    status: 'success',
    data: { task }
  });
});

export const deleteTask = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const task = await Task.findById(req.params.id);

  if (!task) {
    throw new AppError('Task not found', 404);
  }

  const goal = await Goal.findOne({ _id: task.goalId, userId: req.user._id });
  if (!goal) {
    throw new AppError('Unauthorized', 403);
  }

  await Subtask.deleteMany({ taskId: task._id });
  await task.deleteOne();

  res.json({
    status: 'success',
    message: 'Task deleted successfully'
  });
});

export const getSubtasks = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const { taskId } = req.params;

  const task = await Task.findById(taskId);
  if (!task) {
    throw new AppError('Task not found', 404);
  }

  const goal = await Goal.findOne({ _id: task.goalId, userId: req.user._id });
  if (!goal) {
    throw new AppError('Unauthorized', 403);
  }

  const subtasks = await Subtask.find({ taskId });

  res.json({
    status: 'success',
    data: { subtasks }
  });
});

export const createSubtask = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const { taskId } = req.params;

  const task = await Task.findById(taskId);
  if (!task) {
    throw new AppError('Task not found', 404);
  }

  const goal = await Goal.findOne({ _id: task.goalId, userId: req.user._id });
  if (!goal) {
    throw new AppError('Unauthorized', 403);
  }

  const subtaskData = {
    ...req.body,
    taskId
  };

  const subtask = await Subtask.create(subtaskData);

  res.status(201).json({
    status: 'success',
    data: { subtask }
  });
});

export const updateSubtask = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const subtask = await Subtask.findById(req.params.id);

  if (!subtask) {
    throw new AppError('Subtask not found', 404);
  }

  const task = await Task.findById(subtask.taskId);
  if (!task) {
    throw new AppError('Task not found', 404);
  }

  const goal = await Goal.findOne({ _id: task.goalId, userId: req.user._id });
  if (!goal) {
    throw new AppError('Unauthorized', 403);
  }

  Object.assign(subtask, req.body);
  await subtask.save();

  res.json({
    status: 'success',
    data: { subtask }
  });
});

export const deleteSubtask = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const subtask = await Subtask.findById(req.params.id);

  if (!subtask) {
    throw new AppError('Subtask not found', 404);
  }

  const task = await Task.findById(subtask.taskId);
  if (!task) {
    throw new AppError('Task not found', 404);
  }

  const goal = await Goal.findOne({ _id: task.goalId, userId: req.user._id });
  if (!goal) {
    throw new AppError('Unauthorized', 403);
  }

  await subtask.deleteOne();

  res.json({
    status: 'success',
    message: 'Subtask deleted successfully'
  });
});
