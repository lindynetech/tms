import { Router } from 'express';
import * as habitController from '../controllers/habit.controller.js';
import { authenticate } from '../middleware/auth.js';

const router = Router();

router.use(authenticate);

router.get('/', habitController.getHabits);
router.post('/', habitController.createHabit);
router.get('/:id', habitController.getHabit);
router.put('/:id', habitController.updateHabit);
router.delete('/:id', habitController.deleteHabit);
router.post('/:habitId/track', habitController.trackHabit);
router.post('/:id/reset', habitController.resetHabit);

export default router;
