import mongoose, { Schema, Document, Types } from 'mongoose';

export interface IMindstorm extends Document {
  userId: Types.ObjectId;
  question: string;
  category: string;
  active: boolean;
  createdAt: Date;
  updatedAt: Date;
}

const mindstormSchema = new Schema<IMindstorm>(
  {
    userId: {
      type: Schema.Types.ObjectId,
      ref: 'User',
      required: true,
      index: true
    },
    question: {
      type: String,
      required: [true, 'Question is required'],
      maxlength: [500, 'Question cannot exceed 500 characters']
    },
    category: {
      type: String,
      maxlength: 100,
      default: 'General'
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

mindstormSchema.index({ userId: 1, active: 1 });

export const Mindstorm = mongoose.model<IMindstorm>('Mindstorm', mindstormSchema);

export interface IMindstormIdea extends Document {
  mindstormId: Types.ObjectId;
  idea: string;
  rating?: number;
  implemented: boolean;
  createdAt: Date;
  updatedAt: Date;
}

const mindstormIdeaSchema = new Schema<IMindstormIdea>(
  {
    mindstormId: {
      type: Schema.Types.ObjectId,
      ref: 'Mindstorm',
      required: true,
      index: true
    },
    idea: {
      type: String,
      required: [true, 'Idea is required'],
      maxlength: [1000, 'Idea cannot exceed 1000 characters']
    },
    rating: {
      type: Number,
      min: 1,
      max: 5,
      default: null
    },
    implemented: {
      type: Boolean,
      default: false
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

mindstormIdeaSchema.index({ mindstormId: 1 });

export const MindstormIdea = mongoose.model<IMindstormIdea>('MindstormIdea', mindstormIdeaSchema);
