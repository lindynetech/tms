import { Response, NextFunction } from 'express';
import { ReadingList, ReadingListNote } from '../models/ReadingList.js';
import { AppError, asyncHandler } from '../middleware/errorHandler.js';
import { AuthRequest } from '../middleware/auth.js';

export const getReadingList = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const readingList = await ReadingList.find({ userId: req.user._id }).sort({ createdAt: -1 });

  res.json({
    status: 'success',
    data: { readingList }
  });
});

export const getReadingItem = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const item = await ReadingList.findOne({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!item) {
    throw new AppError('Reading item not found', 404);
  }

  const notes = await ReadingListNote.find({ readingListId: item._id }).sort({ createdAt: -1 });

  res.json({
    status: 'success',
    data: { item, notes }
  });
});

export const createReadingItem = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const itemData = {
    ...req.body,
    userId: req.user._id
  };

  const item = await ReadingList.create(itemData);

  res.status(201).json({
    status: 'success',
    data: { item }
  });
});

export const updateReadingItem = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const item = await ReadingList.findOneAndUpdate(
    { _id: req.params.id, userId: req.user._id },
    req.body,
    { new: true, runValidators: true }
  );

  if (!item) {
    throw new AppError('Reading item not found', 404);
  }

  res.json({
    status: 'success',
    data: { item }
  });
});

export const deleteReadingItem = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const item = await ReadingList.findOneAndDelete({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!item) {
    throw new AppError('Reading item not found', 404);
  }

  await ReadingListNote.deleteMany({ readingListId: item._id });

  res.json({
    status: 'success',
    message: 'Reading item deleted successfully'
  });
});

export const createNote = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const { itemId } = req.params;

  const item = await ReadingList.findOne({ _id: itemId, userId: req.user._id });
  if (!item) {
    throw new AppError('Reading item not found', 404);
  }

  const noteData = {
    ...req.body,
    readingListId: itemId
  };

  const note = await ReadingListNote.create(noteData);

  res.status(201).json({
    status: 'success',
    data: { note }
  });
});

export const updateNote = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const note = await ReadingListNote.findById(req.params.noteId);

  if (!note) {
    throw new AppError('Note not found', 404);
  }

  const item = await ReadingList.findOne({ _id: note.readingListId, userId: req.user._id });
  if (!item) {
    throw new AppError('Unauthorized', 403);
  }

  Object.assign(note, req.body);
  await note.save();

  res.json({
    status: 'success',
    data: { note }
  });
});

export const deleteNote = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const note = await ReadingListNote.findById(req.params.noteId);

  if (!note) {
    throw new AppError('Note not found', 404);
  }

  const item = await ReadingList.findOne({ _id: note.readingListId, userId: req.user._id });
  if (!item) {
    throw new AppError('Unauthorized', 403);
  }

  await note.deleteOne();

  res.json({
    status: 'success',
    message: 'Note deleted successfully'
  });
});
