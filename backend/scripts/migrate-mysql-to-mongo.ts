import mysql from 'mysql2/promise';
import mongoose from 'mongoose';
import { config } from '../src/config/app.js';
import { User } from '../src/models/User.js';
import { Goal } from '../src/models/Goal.js';
import { Task } from '../src/models/Task.js';
import { Subtask } from '../src/models/Subtask.js';
import { DailyGoal } from '../src/models/DailyGoal.js';
import { Habit, HabitDay } from '../src/models/Habit.js';
import { Mindstorm, MindstormIdea } from '../src/models/Mindstorm.js';
import { ReadingList, ReadingListNote } from '../src/models/ReadingList.js';
import { Vendor } from '../src/models/Vendor.js';
import { Billing } from '../src/models/Billing.js';

const MYSQL_CONFIG = {
  host: process.env.MYSQL_HOST || 'localhost',
  port: parseInt(process.env.MYSQL_PORT || '3306'),
  user: process.env.MYSQL_USER || 'tms',
  password: process.env.MYSQL_PASSWORD || 'secret',
  database: process.env.MYSQL_DATABASE || 'tms'
};

const migrate = async () => {
  let mysqlConnection: mysql.Connection | null = null;

  try {
    console.log('🔄 Starting migration from MySQL to MongoDB...\n');

    console.log('Connecting to MySQL...');
    mysqlConnection = await mysql.createConnection(MYSQL_CONFIG);
    console.log('✓ Connected to MySQL\n');

    console.log('Connecting to MongoDB...');
    await mongoose.connect(config.mongodb.uri);
    console.log('✓ Connected to MongoDB\n');

    console.log('Clearing existing MongoDB data...');
    await Promise.all([
      User.deleteMany({}),
      Goal.deleteMany({}),
      Task.deleteMany({}),
      Subtask.deleteMany({}),
      DailyGoal.deleteMany({}),
      Habit.deleteMany({}),
      HabitDay.deleteMany({}),
      Mindstorm.deleteMany({}),
      MindstormIdea.deleteMany({}),
      ReadingList.deleteMany({}),
      ReadingListNote.deleteMany({}),
      Vendor.deleteMany({}),
      Billing.deleteMany({})
    ]);
    console.log('✓ Cleared MongoDB collections\n');

    const userIdMap = new Map<number, string>();
    const goalIdMap = new Map<number, string>();
    const taskIdMap = new Map<number, string>();
    const mindstormIdMap = new Map<number, string>();
    const habitIdMap = new Map<number, string>();
    const readingListIdMap = new Map<number, string>();

    console.log('Migrating users...');
    const [users] = await mysqlConnection.execute('SELECT * FROM users');
    for (const mysqlUser of users as any[]) {
      const mongoUser = await User.create({
        name: mysqlUser.name,
        email: mysqlUser.email,
        password: mysqlUser.password,
        emailVerifiedAt: mysqlUser.email_verified_at,
        rememberToken: mysqlUser.remember_token,
        createdAt: mysqlUser.created_at,
        updatedAt: mysqlUser.updated_at
      });
      userIdMap.set(mysqlUser.id, mongoUser._id.toString());
    }
    console.log(`✓ Migrated ${users.length} users\n`);

    console.log('Migrating billing...');
    const [billings] = await mysqlConnection.execute('SELECT * FROM billing');
    for (const billing of billings as any[]) {
      await Billing.create({
        userId: userIdMap.get(billing.user_id),
        paymentMethod: billing.payment_method,
        paymentDate: billing.payment_date,
        paymentAmount: billing.payment_amount,
        paidTill: billing.paid_till,
        status: billing.status,
        createdAt: billing.created_at,
        updatedAt: billing.updated_at
      });
    }
    console.log(`✓ Migrated ${billings.length} billing records\n`);

    console.log('Migrating goals...');
    const [goals] = await mysqlConnection.execute('SELECT * FROM goals');
    for (const goal of goals as any[]) {
      const mongoGoal = await Goal.create({
        userId: userIdMap.get(goal.user_id),
        goal: goal.goal,
        priority: goal.priority,
        urgency: goal.urgency,
        deadline: goal.deadline,
        status: goal.status,
        stage: goal.stage,
        smart: goal.smart === 1,
        type: goal.type,
        createdAt: goal.created_at,
        updatedAt: goal.updated_at
      });
      goalIdMap.set(goal.id, mongoGoal._id.toString());
    }
    console.log(`✓ Migrated ${goals.length} goals\n`);

    console.log('Migrating tasks...');
    const [tasks] = await mysqlConnection.execute('SELECT * FROM goals_tasks');
    for (const task of tasks as any[]) {
      const mongoTask = await Task.create({
        goalId: goalIdMap.get(task.goal_id),
        task: task.task,
        status: task.status,
        priority: task.priority,
        duedate: task.duedate,
        assignedTo: task.assignedto,
        createdAt: task.created_at,
        updatedAt: task.updated_at
      });
      taskIdMap.set(task.id, mongoTask._id.toString());
    }
    console.log(`✓ Migrated ${tasks.length} tasks\n`);

    console.log('Migrating subtasks...');
    const [subtasks] = await mysqlConnection.execute('SELECT * FROM goals_sub_tasks');
    for (const subtask of subtasks as any[]) {
      await Subtask.create({
        taskId: taskIdMap.get(subtask.task_id),
        subtask: subtask.subtask,
        status: subtask.status,
        createdAt: subtask.created_at,
        updatedAt: subtask.updated_at
      });
    }
    console.log(`✓ Migrated ${subtasks.length} subtasks\n`);

    console.log('Migrating daily goals...');
    const [dailyGoals] = await mysqlConnection.execute('SELECT * FROM daily_goals');
    for (const dailyGoal of dailyGoals as any[]) {
      await DailyGoal.create({
        userId: userIdMap.get(dailyGoal.user_id),
        goal: dailyGoal.goal,
        priority: dailyGoal.priority,
        urgency: dailyGoal.urgency,
        deadline: dailyGoal.deadline,
        type: dailyGoal.type
      });
    }
    console.log(`✓ Migrated ${dailyGoals.length} daily goals\n`);

    console.log('Migrating habits...');
    const [habits] = await mysqlConnection.execute('SELECT * FROM habits');
    for (const habit of habits as any[]) {
      const mongoHabit = await Habit.create({
        userId: userIdMap.get(habit.user_id),
        habit: habit.habit,
        frequency: habit.frequency || 'Daily',
        streak: habit.streak || 0,
        longestStreak: habit.longest_streak || 0,
        startDate: habit.start_date || new Date(),
        active: habit.active !== 0,
        createdAt: habit.created_at,
        updatedAt: habit.updated_at
      });
      habitIdMap.set(habit.id, mongoHabit._id.toString());
    }
    console.log(`✓ Migrated ${habits.length} habits\n`);

    console.log('Migrating habit days...');
    const [habitDays] = await mysqlConnection.execute('SELECT * FROM habits_days');
    for (const habitDay of habitDays as any[]) {
      await HabitDay.create({
        habitId: habitIdMap.get(habitDay.habit_id),
        date: habitDay.date,
        completed: habitDay.completed === 1,
        notes: habitDay.notes,
        createdAt: habitDay.created_at,
        updatedAt: habitDay.updated_at
      });
    }
    console.log(`✓ Migrated ${habitDays.length} habit days\n`);

    console.log('Migrating mindstorms...');
    const [mindstorms] = await mysqlConnection.execute('SELECT * FROM mindstorms');
    for (const mindstorm of mindstorms as any[]) {
      const mongoMindstorm = await Mindstorm.create({
        userId: userIdMap.get(mindstorm.user_id),
        question: mindstorm.question,
        category: mindstorm.category || 'General',
        active: mindstorm.active !== 0,
        createdAt: mindstorm.created_at,
        updatedAt: mindstorm.updated_at
      });
      mindstormIdMap.set(mindstorm.id, mongoMindstorm._id.toString());
    }
    console.log(`✓ Migrated ${mindstorms.length} mindstorms\n`);

    console.log('Migrating mindstorm ideas...');
    const [ideas] = await mysqlConnection.execute('SELECT * FROM mindstorms_ideas');
    for (const idea of ideas as any[]) {
      await MindstormIdea.create({
        mindstormId: mindstormIdMap.get(idea.mindstorm_id),
        idea: idea.idea,
        rating: idea.rating,
        implemented: idea.implemented === 1,
        createdAt: idea.created_at,
        updatedAt: idea.updated_at
      });
    }
    console.log(`✓ Migrated ${ideas.length} mindstorm ideas\n`);

    console.log('Migrating reading list...');
    const [readingList] = await mysqlConnection.execute('SELECT * FROM readinglist');
    for (const item of readingList as any[]) {
      const mongoItem = await ReadingList.create({
        userId: userIdMap.get(item.user_id),
        title: item.title,
        author: item.author,
        type: item.type || 'Book',
        status: item.status,
        priority: item.priority,
        startDate: item.start_date,
        completionDate: item.completion_date,
        rating: item.rating,
        createdAt: item.created_at,
        updatedAt: item.updated_at
      });
      readingListIdMap.set(item.id, mongoItem._id.toString());
    }
    console.log(`✓ Migrated ${readingList.length} reading list items\n`);

    console.log('Migrating reading list notes...');
    const [notes] = await mysqlConnection.execute('SELECT * FROM readinglist_notes');
    for (const note of notes as any[]) {
      await ReadingListNote.create({
        readingListId: readingListIdMap.get(note.readinglist_id),
        note: note.note,
        page: note.page,
        chapter: note.chapter,
        createdAt: note.created_at,
        updatedAt: note.updated_at
      });
    }
    console.log(`✓ Migrated ${notes.length} reading notes\n`);

    console.log('Migrating vendors...');
    const [vendors] = await mysqlConnection.execute('SELECT * FROM vendors');
    for (const vendor of vendors as any[]) {
      await Vendor.create({
        userId: userIdMap.get(vendor.user_id),
        name: vendor.name,
        email: vendor.email,
        phone: vendor.phone,
        company: vendor.company,
        role: vendor.role,
        notes: vendor.notes,
        active: vendor.active !== 0,
        createdAt: vendor.created_at,
        updatedAt: vendor.updated_at
      });
    }
    console.log(`✓ Migrated ${vendors.length} vendors\n`);

    console.log('✅ Migration completed successfully!\n');

    console.log('Summary:');
    console.log(`- Users: ${users.length}`);
    console.log(`- Goals: ${goals.length}`);
    console.log(`- Tasks: ${tasks.length}`);
    console.log(`- Subtasks: ${subtasks.length}`);
    console.log(`- Daily Goals: ${dailyGoals.length}`);
    console.log(`- Habits: ${habits.length}`);
    console.log(`- Reading List: ${readingList.length}`);
    console.log(`- Vendors: ${vendors.length}\n`);

  } catch (error) {
    console.error('❌ Migration failed:', error);
    process.exit(1);
  } finally {
    if (mysqlConnection) {
      await mysqlConnection.end();
    }
    await mongoose.connection.close();
    process.exit(0);
  }
};

migrate();
