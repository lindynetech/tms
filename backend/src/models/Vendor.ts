import mongoose, { Schema, Document, Types } from 'mongoose';

export interface IVendor extends Document {
  userId: Types.ObjectId;
  name: string;
  email?: string;
  phone?: string;
  company?: string;
  role?: string;
  notes?: string;
  active: boolean;
  createdAt: Date;
  updatedAt: Date;
}

const vendorSchema = new Schema<IVendor>(
  {
    userId: {
      type: Schema.Types.ObjectId,
      ref: 'User',
      required: true,
      index: true
    },
    name: {
      type: String,
      required: [true, 'Name is required'],
      maxlength: [255, 'Name cannot exceed 255 characters']
    },
    email: {
      type: String,
      lowercase: true,
      trim: true,
      maxlength: 255,
      match: [/^\S+@\S+\.\S+$/, 'Please provide a valid email']
    },
    phone: {
      type: String,
      maxlength: 40
    },
    company: {
      type: String,
      maxlength: 255
    },
    role: {
      type: String,
      maxlength: 100
    },
    notes: {
      type: String
    },
    active: {
      type: Boolean,
      default: true
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

vendorSchema.index({ userId: 1, active: 1 });

export const Vendor = mongoose.model<IVendor>('Vendor', vendorSchema);
