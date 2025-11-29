import mongoose, { Schema, Document, Types } from 'mongoose';

export interface ITask extends Document {
  goalId: Types.ObjectId;
  task: string;
  status: string;
  priority: string;
  duedate: Date;
  assignedTo?: string;
  createdAt: Date;
  updatedAt: Date;
}

const taskSchema = new Schema<ITask>(
  {
    goalId: {
      type: Schema.Types.ObjectId,
      ref: 'Goal',
      required: true,
      index: true
    },
    task: {
      type: String,
      required: [true, 'Task is required'],
      maxlength: [255, 'Task cannot exceed 255 characters']
    },
    status: {
      type: String,
      required: true,
      maxlength: 40,
      default: 'Not Started'
    },
    priority: {
      type: String,
      required: true,
      enum: ['A', 'B', 'C', 'D'],
      maxlength: 4
    },
    duedate: {
      type: Date,
      required: true
    },
    assignedTo: {
      type: String,
      maxlength: 40,
      default: null
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

taskSchema.index({ goalId: 1, status: 1 });

export const Task = mongoose.model<ITask>('Task', taskSchema);
