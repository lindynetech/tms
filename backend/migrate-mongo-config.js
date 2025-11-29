import dotenv from 'dotenv';
dotenv.config();

const config = {
  mongodb: {
    url: process.env.MONGODB_URI || 'mongodb://tms:secret@mongodb:27017/tms?authSource=admin',
    options: {
      useNewUrlParser: true,
      useUnifiedTopology: true,
    }
  },
  migrationsDir: 'src/database/migrations',
  changelogCollectionName: 'migrations',
  migrationFileExtension: '.js',
  useFileHash: false,
  moduleSystem: 'esm',
};

export default config;
