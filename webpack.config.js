const Encore = require('@symfony/webpack-encore');

Encore
    // le répertoire où tous les fichiers compilés vont être stockés
    .setOutputPath('public/build/')
    
    // le chemin public utilisé par le serveur web pour accéder aux fichiers
    .setPublicPath('/build')
    
    // ajoute l'entrée principale de votre application (fichier JavaScript ou CSS)
    .addEntry('app', './assets/app.js')
    .addStyleEntry('styles', './assets/styles.css')
    
    // divise les entrées en plusieurs chunks pour des chargements plus rapides
    .splitEntryChunks()
    
    // active le runtime partagé pour tous les fichiers
    .enableSingleRuntimeChunk()
    
    // nettoie le répertoire de sortie avant chaque construction
    .cleanupOutputBeforeBuild()
    
    // active les sourcemaps pour un débogage plus facile
    .enableSourceMaps(!Encore.isProduction())
    
    // active la versioning (nom de fichier avec hash) pour mieux gérer le cache des navigateurs
    .enableVersioning(Encore.isProduction())
    
    // active le support pour PostCSS (utile pour Tailwind)
    .enablePostCssLoader((options) => {
        options.postcssOptions = {
            config: './postcss.config.js'
        };
    });

module.exports = Encore.getWebpackConfig();
