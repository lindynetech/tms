export const config = {
  nodeEnv: process.env.NODE_ENV || 'development',
  port: parseInt(process.env.PORT || '3000', 10),
  appName: process.env.APP_NAME || 'TMS',
  appUrl: process.env.APP_URL || 'http://localhost:3000',
  frontendUrl: process.env.FRONTEND_URL || 'http://localhost:5173',

  mongodb: {
    uri: process.env.MONGODB_URI || 'mongodb://tms:secret@localhost:27017/tms?authSource=admin',
    testUri: process.env.MONGODB_TEST_URI || 'mongodb://tms:secret@localhost:27017/tms_test?authSource=admin'
  },

  jwt: {
    secret: process.env.JWT_SECRET || 'your-secret-key',
    expiresIn: process.env.JWT_EXPIRES_IN || '7d',
    refreshSecret: process.env.JWT_REFRESH_SECRET || 'your-refresh-secret',
    refreshExpiresIn: process.env.JWT_REFRESH_EXPIRES_IN || '30d'
  },

  bcrypt: {
    rounds: parseInt(process.env.BCRYPT_ROUNDS || '10', 10)
  },

  redis: {
    host: process.env.REDIS_HOST || 'localhost',
    port: parseInt(process.env.REDIS_PORT || '6379', 10),
    password: process.env.REDIS_PASSWORD || ''
  },

  cors: {
    origin: process.env.CORS_ORIGIN || 'http://localhost:5173'
  },

  rateLimit: {
    windowMs: parseInt(process.env.RATE_LIMIT_WINDOW_MS || '900000', 10),
    maxRequests: parseInt(process.env.RATE_LIMIT_MAX_REQUESTS || '100', 10)
  },

  logging: {
    level: process.env.LOG_LEVEL || 'info'
  },

  email: {
    host: process.env.SMTP_HOST || 'localhost',
    port: parseInt(process.env.SMTP_PORT || '1025', 10),
    user: process.env.SMTP_USER || '',
    password: process.env.SMTP_PASSWORD || '',
    from: {
      email: process.env.SMTP_FROM_EMAIL || 'noreply@tms.dev',
      name: process.env.SMTP_FROM_NAME || 'TMS'
    }
  }
};
