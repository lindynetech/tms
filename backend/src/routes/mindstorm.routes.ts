import { Router } from 'express';
import * as mindstormController from '../controllers/mindstorm.controller.js';
import { authenticate } from '../middleware/auth.js';

const router = Router();

router.use(authenticate);

router.get('/', mindstormController.getMindstorms);
router.post('/', mindstormController.createMindstorm);
router.get('/:id', mindstormController.getMindstorm);
router.put('/:id', mindstormController.updateMindstorm);
router.delete('/:id', mindstormController.deleteMindstorm);

router.post('/:mindstormId/ideas', mindstormController.createIdea);
router.put('/ideas/:ideaId', mindstormController.updateIdea);
router.delete('/ideas/:ideaId', mindstormController.deleteIdea);

export default router;
