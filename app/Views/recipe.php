    <?= $this->extend('template') ?>

    <?= $this->section('content') ?>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img class="rounded-4 img-fluid" src="https://source.unsplash.com/Zh0mYmMBZjQ/600x600" />
            </div>
            <div class="col-md-6">
                <h1 class="fw-bolder">{page_title}</h1>
                <p>{recipe_description}</p>
                <div class="row text-center mt-4">
                    <div class="col-4">
                        <span class="material-symbols-outlined material-symbols-no-fill icon-md">schedule</span>
                        <h6 class="fw-bold mb-0">Prep Time</h6>
                        <span class="text-small">{prep_time}</span>
                    </div>
                    <div class="col-4">
                        <span class="material-symbols-outlined material-symbols-no-fill icon-md">local_fire_department</span>
                        <h6 class="fw-bold mb-0">Cook Time</h6>
                        <span class="text-small">{cook_time}</span>
                    </div>
                    <div class="col-4">
                        <span class="material-symbols-outlined material-symbols-no-fill icon-md">group</span>
                        <h6 class="fw-bold mb-0">Yield</h6>
                        <span class="text-small">{yield}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-md-3">
                <h4 class="fw-bold">Ingredients</h4>
                <ul class="list-unstyled ingredients-list">
                    {recipe_ingredients}
                    <li>{ingredient_desc}</li>
                    {/recipe_ingredients}
                </ul>
            </div>
            <div class="col-md-9">
                <h4 class="fw-bold">Directions</h4>
                {recipe_steps}
                <div class="mt-4">
                    <h6 class="directions-step pb-2">STEP {step}</h6>
                    <p>{body}</p>
                </div>
                {/recipe_steps}
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>