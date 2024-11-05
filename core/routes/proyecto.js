const express = require('express');
const router = express.Router();
const proyectoController = require('../controllers/proyectoController');

router.post('/', proyectoController.crearProyecto);
router.get('/', proyectoController.obtenerProyectos);
router.get('/:id', proyectoController.obtenerProyectoPorId);
router.put('/:id', proyectoController.actualizarProyecto);
router.delete('/:id', proyectoController.eliminarProyecto);

module.exports = router;
