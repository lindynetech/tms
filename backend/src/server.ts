import express, { Express, Request, Response, NextFunction } from 'express';
import mongoose from 'mongoose';
import cors from 'cors';
import helmet from 'helmet';
import morgan from 'morgan';
import compression from 'compression';
import cookieParser from 'cookie-parser';
import dotenv from 'dotenv';
import { config } from './config/app.js';
import { connectDatabase } from './config/database.js';
import { errorHandler } from './middleware/errorHandler.js';
import authRoutes from './routes/auth.routes.js';
import goalRoutes from './routes/goal.routes.js';
import taskRoutes from './routes/task.routes.js';
import dailyGoalRoutes from './routes/dailyGoal.routes.js';
import habitRoutes from './routes/habit.routes.js';
import mindstormRoutes from './routes/mindstorm.routes.js';
import readingListRoutes from './routes/readingList.routes.js';
import vendorRoutes from './routes/vendor.routes.js';
import profileRoutes from './routes/profile.routes.js';

dotenv.config();

const app: Express = express();
const PORT = config.port;

app.use(helmet());
app.use(cors({
  origin: config.cors.origin.split(','),
  credentials: true
}));
app.use(compression());
app.use(morgan(config.nodeEnv === 'development' ? 'dev' : 'combined'));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());

app.get('/', (_req: Request, res: Response) => {
  res.json({
    message: 'TMS API Server',
    version: '1.0.0',
    status: 'running'
  });
});

app.get('/health', (_req: Request, res: Response) => {
  res.json({
    status: 'ok',
    mongodb: mongoose.connection.readyState === 1 ? 'connected' : 'disconnected',
    timestamp: new Date().toISOString()
  });
});

app.use('/api/auth', authRoutes);
app.use('/api/goals', goalRoutes);
app.use('/api/tasks', taskRoutes);
app.use('/api/daily-goals', dailyGoalRoutes);
app.use('/api/habits', habitRoutes);
app.use('/api/mindstorms', mindstormRoutes);
app.use('/api/reading-list', readingListRoutes);
app.use('/api/vendors', vendorRoutes);
app.use('/api/profile', profileRoutes);

app.use((_req: Request, res: Response) => {
  res.status(404).json({ error: 'Route not found' });
});

app.use(errorHandler);

const startServer = async () => {
  try {
    await connectDatabase();

    app.listen(PORT, () => {
      console.log(`🚀 Server running on port ${PORT}`);
      console.log(`📝 Environment: ${config.nodeEnv}`);
      console.log(`🌐 API URL: ${config.appUrl}`);
    });
  } catch (error) {
    console.error('Failed to start server:', error);
    process.exit(1);
  }
};

startServer();

process.on('unhandledRejection', (err: Error) => {
  console.error('Unhandled Rejection:', err);
  process.exit(1);
});

export default app;
