import mongoose, { Schema, Document, Types } from 'mongoose';

export interface IDailyGoal extends Document {
  userId: Types.ObjectId;
  goal: string;
  priority: string;
  urgency: number;
  deadline: Date;
  type: string;
  createdAt: Date;
  updatedAt: Date;
}

const dailyGoalSchema = new Schema<IDailyGoal>(
  {
    userId: {
      type: Schema.Types.ObjectId,
      ref: 'User',
      required: true,
      index: true
    },
    goal: {
      type: String,
      required: [true, 'Goal is required'],
      maxlength: [255, 'Goal cannot exceed 255 characters']
    },
    priority: {
      type: String,
      required: true,
      enum: ['A', 'B', 'C', 'D'],
      maxlength: 4
    },
    urgency: {
      type: Number,
      required: true,
      min: 1,
      max: 10
    },
    deadline: {
      type: Date,
      required: true
    },
    type: {
      type: String,
      required: true,
      maxlength: 40
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

dailyGoalSchema.index({ userId: 1, deadline: 1 });

export const DailyGoal = mongoose.model<IDailyGoal>('DailyGoal', dailyGoalSchema);
