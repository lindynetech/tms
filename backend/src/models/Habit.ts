import mongoose, { Schema, Document, Types } from 'mongoose';

export interface IHabit extends Document {
  userId: Types.ObjectId;
  habit: string;
  frequency: string;
  streak: number;
  longestStreak: number;
  startDate: Date;
  active: boolean;
  createdAt: Date;
  updatedAt: Date;
}

const habitSchema = new Schema<IHabit>(
  {
    userId: {
      type: Schema.Types.ObjectId,
      ref: 'User',
      required: true,
      index: true
    },
    habit: {
      type: String,
      required: [true, 'Habit is required'],
      maxlength: [255, 'Habit cannot exceed 255 characters']
    },
    frequency: {
      type: String,
      required: true,
      maxlength: 40,
      default: 'Daily'
    },
    streak: {
      type: Number,
      default: 0
    },
    longestStreak: {
      type: Number,
      default: 0
    },
    startDate: {
      type: Date,
      required: true,
      default: Date.now
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

habitSchema.index({ userId: 1, active: 1 });

export const Habit = mongoose.model<IHabit>('Habit', habitSchema);

export interface IHabitDay extends Document {
  habitId: Types.ObjectId;
  date: Date;
  completed: boolean;
  notes?: string;
  createdAt: Date;
  updatedAt: Date;
}

const habitDaySchema = new Schema<IHabitDay>(
  {
    habitId: {
      type: Schema.Types.ObjectId,
      ref: 'Habit',
      required: true,
      index: true
    },
    date: {
      type: Date,
      required: true
    },
    completed: {
      type: Boolean,
      default: false
    },
    notes: {
      type: String,
      maxlength: 500
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

habitDaySchema.index({ habitId: 1, date: 1 }, { unique: true });

export const HabitDay = mongoose.model<IHabitDay>('HabitDay', habitDaySchema);
