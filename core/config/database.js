// const { Sequelize } = require('sequelize');
// require('dotenv').config();

// const sequelize = new Sequelize(process.env.DB_NAME, process.env.DB_USER, process.env.DB_PASSWORD, {
//     host: process.env.DB_HOST,
//     dialect: process.env.DB_DIALECT,
// });

// module.exports = sequelize;

module.exports = {
    HOST: 'dpg-cskmlr3v2p9s73a84ang-a.oregon-postgres.render.com',
    USER: 'examen_final_umg_2024_user',
    PASSWORD: 'HwXh6wdgLAOGX1N0XaqpAsKEPbMC2gcn',
    DB: 'examen_final_umg_2024',
    dialect: 'postgres',
    dialectOptions: {
        ssl: {
            require: true,
            rejectUnauthorized: false, // Esto evita problemas de certificados SSL autofirmados
        },
    },
    pool: {
        max: 5,
        min: 0,
        acquire: 30000,
        idle: 10000,
    },
};
