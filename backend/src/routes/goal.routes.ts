import { Router } from 'express';
import * as goalController from '../controllers/goal.controller.js';
import { authenticate } from '../middleware/auth.js';

const router = Router();

router.use(authenticate);

router.get('/', goalController.getGoals);
router.post('/', goalController.createGoal);
router.get('/:id', goalController.getGoal);
router.put('/:id', goalController.updateGoal);
router.delete('/:id', goalController.deleteGoal);

export default router;
