import { Response, NextFunction } from 'express';
import { Vendor } from '../models/Vendor.js';
import { AppError, asyncHandler } from '../middleware/errorHandler.js';
import { AuthRequest } from '../middleware/auth.js';

export const getVendors = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const vendors = await Vendor.find({ userId: req.user._id }).sort({ name: 1 });

  res.json({
    status: 'success',
    data: { vendors }
  });
});

export const getVendor = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const vendor = await Vendor.findOne({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!vendor) {
    throw new AppError('Vendor not found', 404);
  }

  res.json({
    status: 'success',
    data: { vendor }
  });
});

export const createVendor = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const vendorData = {
    ...req.body,
    userId: req.user._id
  };

  const vendor = await Vendor.create(vendorData);

  res.status(201).json({
    status: 'success',
    data: { vendor }
  });
});

export const updateVendor = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const vendor = await Vendor.findOneAndUpdate(
    { _id: req.params.id, userId: req.user._id },
    req.body,
    { new: true, runValidators: true }
  );

  if (!vendor) {
    throw new AppError('Vendor not found', 404);
  }

  res.json({
    status: 'success',
    data: { vendor }
  });
});

export const deleteVendor = asyncHandler(async (req: AuthRequest, res: Response, next: NextFunction) => {
  const vendor = await Vendor.findOneAndDelete({
    _id: req.params.id,
    userId: req.user._id
  });

  if (!vendor) {
    throw new AppError('Vendor not found', 404);
  }

  res.json({
    status: 'success',
    message: 'Vendor deleted successfully'
  });
});
