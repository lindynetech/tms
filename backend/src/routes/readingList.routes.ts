import { Router } from 'express';
import * as readingListController from '../controllers/readingList.controller.js';
import { authenticate } from '../middleware/auth.js';

const router = Router();

router.use(authenticate);

router.get('/', readingListController.getReadingList);
router.post('/', readingListController.createReadingItem);
router.get('/:id', readingListController.getReadingItem);
router.put('/:id', readingListController.updateReadingItem);
router.delete('/:id', readingListController.deleteReadingItem);

router.post('/:itemId/notes', readingListController.createNote);
router.put('/notes/:noteId', readingListController.updateNote);
router.delete('/notes/:noteId', readingListController.deleteNote);

export default router;
