import { Request, Response, NextFunction } from 'express';
import { Schema } from 'joi';
import { AppError } from './errorHandler.js';

export const validate = (schema: Schema) => {
  return (req: Request, res: Response, next: NextFunction) => {
    const { error, value } = schema.validate(req.body, {
      abortEarly: false,
      stripUnknown: true
    });

    if (error) {
      const errors = error.details.map((detail) => ({
        field: detail.path.join('.'),
        message: detail.message
      }));

      throw new AppError(
        JSON.stringify({ validation_errors: errors }),
        400
      );
    }

    req.body = value;
    next();
  };
};
