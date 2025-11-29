import mongoose, { Schema, Document, Types } from 'mongoose';

export interface ISubtask extends Document {
  taskId: Types.ObjectId;
  subtask: string;
  status: string;
  createdAt: Date;
  updatedAt: Date;
}

const subtaskSchema = new Schema<ISubtask>(
  {
    taskId: {
      type: Schema.Types.ObjectId,
      ref: 'Task',
      required: true,
      index: true
    },
    subtask: {
      type: String,
      required: [true, 'Subtask is required'],
      maxlength: [255, 'Subtask cannot exceed 255 characters']
    },
    status: {
      type: String,
      required: true,
      maxlength: 40,
      default: 'Not Started'
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

subtaskSchema.index({ taskId: 1 });

export const Subtask = mongoose.model<ISubtask>('Subtask', subtaskSchema);
