import mongoose from 'mongoose';
import { config } from '../../config/app.js';
import { User } from '../../models/User.js';
import { Goal } from '../../models/Goal.js';
import { Task } from '../../models/Task.js';
import { DailyGoal } from '../../models/DailyGoal.js';
import { ReadingList, ReadingListNote } from '../../models/ReadingList.js';
import { Vendor } from '../../models/Vendor.js';
import { Billing } from '../../models/Billing.js';

const seed = async () => {
  try {
    await mongoose.connect(config.mongodb.uri);
    console.log('Connected to MongoDB');

    await User.deleteMany({});
    await Goal.deleteMany({});
    await Task.deleteMany({});
    await DailyGoal.deleteMany({});
    await ReadingList.deleteMany({});
    await ReadingListNote.deleteMany({});
    await Vendor.deleteMany({});
    await Billing.deleteMany({});

    const admin = await User.create({
      name: 'Admin User',
      email: 'admin@tms.dev',
      password: 'password',
      emailVerifiedAt: new Date()
    });

    console.log('✓ Created admin user');

    await Billing.create({
      userId: admin._id,
      status: 'Free Trial'
    });

    const goal1 = await Goal.create({
      userId: admin._id,
      goal: 'Master Python and build 5 production applications by December 2025',
      priority: 'A',
      urgency: 1,
      deadline: new Date('2025-12-31'),
      status: 'In Progress',
      stage: 'Execution',
      smart: true,
      type: 'Self-Development'
    });

    const goal2 = await Goal.create({
      userId: admin._id,
      goal: 'Complete AWS Solutions Architect Professional certification',
      priority: 'A',
      urgency: 2,
      deadline: new Date('2025-06-30'),
      status: 'Not Started',
      stage: 'Planning',
      smart: true,
      type: 'Professional Development'
    });

    console.log('✓ Created 2 goals');

    await Task.create([
      {
        goalId: goal1._id,
        task: 'Complete Python fundamentals course',
        status: 'Completed',
        priority: 'A',
        duedate: new Date('2025-02-15'),
        assignedTo: null
      },
      {
        goalId: goal1._id,
        task: 'Build a Django REST API project',
        status: 'In Progress',
        priority: 'A',
        duedate: new Date('2025-03-30'),
        assignedTo: null
      },
      {
        goalId: goal2._id,
        task: 'Study AWS networking services',
        status: 'Not Started',
        priority: 'B',
        duedate: new Date('2025-05-15'),
        assignedTo: null
      }
    ]);

    console.log('✓ Created tasks for goals');

    await DailyGoal.create([
      {
        userId: admin._id,
        goal: 'Complete AWS Solutions Architect Certification',
        priority: 'A',
        urgency: 1,
        deadline: new Date('2025-03-15'),
        type: 'Self-Development'
      },
      {
        userId: admin._id,
        goal: 'Launch new product feature by Q2',
        priority: 'B',
        urgency: 2,
        deadline: new Date('2025-06-30'),
        type: 'Business'
      }
    ]);

    console.log('✓ Created 2 daily goals');

    const reading1 = await ReadingList.create({
      userId: admin._id,
      title: 'Clean Architecture',
      author: 'Robert C. Martin',
      type: 'Book',
      status: 'Reading',
      priority: 'A',
      startDate: new Date('2025-01-01'),
      rating: null
    });

    const reading2 = await ReadingList.create({
      userId: admin._id,
      title: 'Designing Data-Intensive Applications',
      author: 'Martin Kleppmann',
      type: 'Book',
      status: 'To Read',
      priority: 'A',
      startDate: null,
      rating: null
    });

    const reading3 = await ReadingList.create({
      userId: admin._id,
      title: 'The Pragmatic Programmer',
      author: 'Andrew Hunt, David Thomas',
      type: 'Book',
      status: 'Completed',
      priority: 'A',
      startDate: new Date('2024-10-01'),
      completionDate: new Date('2024-12-15'),
      rating: 5
    });

    console.log('✓ Created 3 reading list items');

    await ReadingListNote.create([
      {
        readingListId: reading1._id,
        note: 'Software architecture is about making decisions that can be changed later',
        page: 45,
        chapter: 'Chapter 3'
      },
      {
        readingListId: reading3._id,
        note: 'DRY principle - Don\'t Repeat Yourself',
        page: 30,
        chapter: 'Chapter 2'
      }
    ]);

    console.log('✓ Created reading notes');

    await Vendor.create([
      {
        userId: admin._id,
        name: 'John Smith',
        email: 'john@example.com',
        phone: '+1-555-0100',
        company: 'TechCorp Solutions',
        role: 'Project Manager',
        notes: 'Primary contact for client projects',
        active: true
      },
      {
        userId: admin._id,
        name: 'Sarah Johnson',
        email: 'sarah@designstudio.com',
        phone: '+1-555-0200',
        company: 'Creative Design Studio',
        role: 'Lead Designer',
        notes: 'UI/UX consultant',
        active: true
      }
    ]);

    console.log('✓ Created 2 vendors');

    console.log('\n✅ Database seeded successfully!');
    console.log('\nDefault Login Credentials:');
    console.log('Email: admin@tms.dev');
    console.log('Password: password\n');

    process.exit(0);
  } catch (error) {
    console.error('❌ Seeding failed:', error);
    process.exit(1);
  }
};

seed();
