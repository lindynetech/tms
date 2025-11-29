import { Response, NextFunction } from 'express';
import { Mindstorm, MindstormIdea } from '../models/Mindstorm.js';
import { AppError, asyncHandler } from '../middleware/errorHandler.js';
import { AuthRequest } from '../middleware/auth.js';

export const getMindstorms = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const mindstorms = await Mindstorm.find({ userId: req.user._id }).sort({ createdAt: -1 });

  res.json({
    status: 'success',
    data: { mindstorms }
  });
});

export const getMindstorm = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const mindstorm = await Mindstorm.findOne({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!mindstorm) {
    throw new AppError('Mindstorm not found', 404);
  }

  const ideas = await MindstormIdea.find({ mindstormId: mindstorm._id }).sort({ createdAt: -1 });

  res.json({
    status: 'success',
    data: { mindstorm, ideas }
  });
});

export const createMindstorm = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const mindstormData = {
    ...req.body,
    userId: req.user._id
  };

  const mindstorm = await Mindstorm.create(mindstormData);

  res.status(201).json({
    status: 'success',
    data: { mindstorm }
  });
});

export const updateMindstorm = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const mindstorm = await Mindstorm.findOneAndUpdate(
    { _id: req.params.id, userId: req.user._id },
    req.body,
    { new: true, runValidators: true }
  );

  if (!mindstorm) {
    throw new AppError('Mindstorm not found', 404);
  }

  res.json({
    status: 'success',
    data: { mindstorm }
  });
});

export const deleteMindstorm = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const mindstorm = await Mindstorm.findOneAndDelete({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!mindstorm) {
    throw new AppError('Mindstorm not found', 404);
  }

  await MindstormIdea.deleteMany({ mindstormId: mindstorm._id });

  res.json({
    status: 'success',
    message: 'Mindstorm deleted successfully'
  });
});

export const createIdea = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const { mindstormId } = req.params;

  const mindstorm = await Mindstorm.findOne({ _id: mindstormId, userId: req.user._id });
  if (!mindstorm) {
    throw new AppError('Mindstorm not found', 404);
  }

  const ideaData = {
    ...req.body,
    mindstormId
  };

  const idea = await MindstormIdea.create(ideaData);

  res.status(201).json({
    status: 'success',
    data: { idea }
  });
});

export const updateIdea = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const idea = await MindstormIdea.findById(req.params.ideaId);

  if (!idea) {
    throw new AppError('Idea not found', 404);
  }

  const mindstorm = await Mindstorm.findOne({ _id: idea.mindstormId, userId: req.user._id });
  if (!mindstorm) {
    throw new AppError('Unauthorized', 403);
  }

  Object.assign(idea, req.body);
  await idea.save();

  res.json({
    status: 'success',
    data: { idea }
  });
});

export const deleteIdea = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const idea = await MindstormIdea.findById(req.params.ideaId);

  if (!idea) {
    throw new AppError('Idea not found', 404);
  }

  const mindstorm = await Mindstorm.findOne({ _id: idea.mindstormId, userId: req.user._id });
  if (!mindstorm) {
    throw new AppError('Unauthorized', 403);
  }

  await idea.deleteOne();

  res.json({
    status: 'success',
    message: 'Idea deleted successfully'
  });
});
