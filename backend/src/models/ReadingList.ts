import mongoose, { Schema, Document, Types } from 'mongoose';

export interface IReadingList extends Document {
  userId: Types.ObjectId;
  title: string;
  author?: string;
  type: string;
  status: string;
  priority: string;
  startDate?: Date;
  completionDate?: Date;
  rating?: number;
  createdAt: Date;
  updatedAt: Date;
}

const readingListSchema = new Schema<IReadingList>(
  {
    userId: {
      type: Schema.Types.ObjectId,
      ref: 'User',
      required: true,
      index: true
    },
    title: {
      type: String,
      required: [true, 'Title is required'],
      maxlength: [255, 'Title cannot exceed 255 characters']
    },
    author: {
      type: String,
      maxlength: 255
    },
    type: {
      type: String,
      required: true,
      maxlength: 40,
      default: 'Book'
    },
    status: {
      type: String,
      required: true,
      maxlength: 40,
      default: 'To Read'
    },
    priority: {
      type: String,
      required: true,
      enum: ['A', 'B', 'C', 'D'],
      maxlength: 4
    },
    startDate: {
      type: Date,
      default: null
    },
    completionDate: {
      type: Date,
      default: null
    },
    rating: {
      type: Number,
      min: 1,
      max: 5,
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

readingListSchema.index({ userId: 1, status: 1 });

export const ReadingList = mongoose.model<IReadingList>('ReadingList', readingListSchema);

export interface IReadingListNote extends Document {
  readingListId: Types.ObjectId;
  note: string;
  page?: number;
  chapter?: string;
  createdAt: Date;
  updatedAt: Date;
}

const readingListNoteSchema = new Schema<IReadingListNote>(
  {
    readingListId: {
      type: Schema.Types.ObjectId,
      ref: 'ReadingList',
      required: true,
      index: true
    },
    note: {
      type: String,
      required: [true, 'Note is required']
    },
    page: {
      type: Number,
      default: null
    },
    chapter: {
      type: String,
      maxlength: 100,
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

readingListNoteSchema.index({ readingListId: 1 });

export const ReadingListNote = mongoose.model<IReadingListNote>('ReadingListNote', readingListNoteSchema);
