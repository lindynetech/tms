import { Router } from 'express';
import * as dailyGoalController from '../controllers/dailyGoal.controller.js';
import { authenticate } from '../middleware/auth.js';

const router = Router();

router.use(authenticate);

router.get('/', dailyGoalController.getDailyGoals);
router.post('/', dailyGoalController.createDailyGoal);
router.put('/:id', dailyGoalController.updateDailyGoal);
router.delete('/:id', dailyGoalController.deleteDailyGoal);
router.delete('/', dailyGoalController.flushDailyGoals);

export default router;
