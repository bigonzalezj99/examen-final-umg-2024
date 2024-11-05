const Proyecto = require('../models/proyecto');

exports.crearProyecto = async (req, res) => {
    try {
        const proyecto = await Proyecto.create(req.body);
        res.status(201).json(proyecto);
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
};

exports.obtenerProyectos = async (req, res) => {
    try {
        const proyectos = await Proyecto.findAll();
        res.json(proyectos);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

exports.obtenerProyectoPorId = async (req, res) => {
    try {
        const proyecto = await Proyecto.findByPk(req.params.id);
        if (proyecto) res.json(proyecto);
        else res.status(404).json({ error: 'Proyecto no encontrado' });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};

exports.actualizarProyecto = async (req, res) => {
    try {
        const [updated] = await Proyecto.update(req.body, { where: { id: req.params.id } });
        if (updated) res.json({ message: 'Proyecto actualizado' });
        else res.status(404).json({ error: 'Proyecto no encontrado' });
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
};

exports.eliminarProyecto = async (req, res) => {
    try {
        const deleted = await Proyecto.destroy({ where: { id: req.params.id } });
        if (deleted) res.json({ message: 'Proyecto eliminado' });
        else res.status(404).json({ error: 'Proyecto no encontrado' });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};
