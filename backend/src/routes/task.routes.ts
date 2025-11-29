import { Router } from 'express';
import * as taskController from '../controllers/task.controller.js';
import { authenticate } from '../middleware/auth.js';

const router = Router();

router.use(authenticate);

router.get('/goal/:goalId', taskController.getTasks);
router.post('/goal/:goalId', taskController.createTask);
router.get('/:id', taskController.getTask);
router.put('/:id', taskController.updateTask);
router.delete('/:id', taskController.deleteTask);

router.get('/:taskId/subtasks', taskController.getSubtasks);
router.post('/:taskId/subtasks', taskController.createSubtask);
router.put('/subtasks/:id', taskController.updateSubtask);
router.delete('/subtasks/:id', taskController.deleteSubtask);

export default router;
