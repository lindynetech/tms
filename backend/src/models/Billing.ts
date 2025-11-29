import mongoose, { Schema, Document, Types } from 'mongoose';

export interface IBilling extends Document {
  userId: Types.ObjectId;
  paymentMethod?: string;
  paymentDate?: Date;
  paymentAmount?: number;
  paidTill?: Date;
  status: string;
  createdAt: Date;
  updatedAt: Date;
}

const billingSchema = new Schema<IBilling>(
  {
    userId: {
      type: Schema.Types.ObjectId,
      ref: 'User',
      required: true,
      unique: true,
      index: true
    },
    paymentMethod: {
      type: String,
      maxlength: 40,
      default: null
    },
    paymentDate: {
      type: Date,
      default: null
    },
    paymentAmount: {
      type: Number,
      min: 0,
      default: null
    },
    paidTill: {
      type: Date,
      default: null
    },
    status: {
      type: String,
      required: true,
      maxlength: 255,
      default: 'Free Trial'
    }
  },
  {
    timestamps: true,
    toJSON: {
      transform: (_doc, ret) => {
        const { __v, ...rest } = ret;
        return rest;
      }
    }
  }
);

billingSchema.index({ userId: 1 });

export const Billing = mongoose.model<IBilling>('Billing', billingSchema);
