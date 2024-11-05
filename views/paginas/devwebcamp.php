<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo; ?></h2>

    <p class="devwebcamp__descripcion">Conozca la conferencia más importante de Latinoamérica.</p>

    <div class="devwebcamp__grid">
        <div <?php aosAnimacion(); ?> class="devwebcamp__imagen">
            <picture>
                <source srcset="/build/img/sobre_devwebcamp.avif" type="image/avif" />
                <source srcset="/build/img/sobre_devwebcamp.webp" type="image/webp" />
                <img loading="lazy" width="200" height="200" src="/build/img/sobre_devwebcamp.jpg" alt="Imagen DevWebCamp" />
            </picture>
        </div>

        <div class="devwebcamp__contenido">
            <p <?php aosAnimacion(); ?> class="devwebcamp__texto">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus, placeat maiores? Asperiores maxime dolorem assumenda ex. Ducimus accusantium consequatur pariatur quaerat libero voluptatum reiciendis hic obcaecati ratione sit? Doloribus, corrupti?</p>

            <p <?php aosAnimacion(); ?> class="devwebcamp__texto">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus, placeat maiores? Asperiores maxime dolorem assumenda ex. Ducimus accusantium consequatur pariatur quaerat libero voluptatum reiciendis hic obcaecati ratione sit? Doloribus, corrupti?</p>
        </div>
    </div>
</main>