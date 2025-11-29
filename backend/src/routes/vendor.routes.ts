import { Router } from 'express';
import * as vendorController from '../controllers/vendor.controller.js';
import { authenticate } from '../middleware/auth.js';

const router = Router();

router.use(authenticate);

router.get('/', vendorController.getVendors);
router.post('/', vendorController.createVendor);
router.get('/:id', vendorController.getVendor);
router.put('/:id', vendorController.updateVendor);
router.delete('/:id', vendorController.deleteVendor);

export default router;
