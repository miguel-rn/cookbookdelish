    <?= $this->extend('template') ?>

    <?= $this->section('content') ?>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3 class="fw-bolder">Categories</h3>
                <div class="accordion accordion-flush" id="accordionFlush-{id}">
                    {categories}
                    <div class="accordion-item accordion-filter border-0">
                        <h2 class="accordion-header" id="flush-heading-{id}">
                            <button class="accordion-button collapsed ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{id}" aria-expanded="false" aria-controls="flush-collapse-{id}">{name}</button>
                        </h2>
                        <div id="flush-collapse-{id}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{id}" data-bs-parent="#accordionFlush-{id}">
                            <div class="accordion-body py-0">
                                <ul class="list-unstyled filter-list">
                                    {children}
                                    <li><a href="#">{child_name}</a></li>
                                    {/children}
                                </ul>
                            </div>
                        </div>
                    </div>
                    {/categories}
                </div>
            </div>
            <div class="col-md-9">
                <div class="row row-cols-2 row-cols-md-3">
                    {recipes}
                    <div class="col mb-5">
                        <a class="text-decoration-none text-dark" href="{base_url}recipe/{id}/{slug}">
                            <div class="card h-100 border-0 recipe-card">
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
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>