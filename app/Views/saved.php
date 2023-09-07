<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container">
    {if empty($recipes)}
    <div class="row">
        <div class="col text-center">
            <h1 class="fw-bolder">No Saved Recipes</h1>
            <p class="lead">You have not saved any recipes yet.</p>
            <a class="btn btn-bd-primary" href="{base_url}">Explore Recipes</a>
        </div>
    </div>
    {else}
    <h3 class="fw-bolder">Saved Recipes</h3>
    <div class="row row-cols-2 row-cols-md-4">
        {recipes}
        <div class="col mb-5">
            <a class="text-decoration-none text-dark" href="{base_url}recipe/{id}/{slug}">
                <div class="card h-100 border-0 recipe-card" data-recipeId={id}>
                    <img class="card-img rounded-4 recipe-card-img" src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=160&ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTY3MzkzNTA2Ng&ixlib=rb-4.0.3&q=80&w=300" />
                    <div class="card-img-overlay">
                        <span class="material-symbols-outlined recipe-card-save" data-recipeId={id}> favorite </span>
                    </div>
                    <div class="card-body ps-0 pb-0">
                        <h6 class="fw-bold">{title}</h6>
                    </div>
                </div>
            </a>
        </div>
        {/recipes}
    </div>
    {endif}
</div>
<?= $this->endSection() ?>