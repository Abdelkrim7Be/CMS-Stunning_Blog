<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Category</h1>
        <a href="/admin/categories" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="/admin/categories" method="POST">
                <div class="form-group">
                    <label for="title">Category Name *</label>
                    <input type="text"
                        class="form-control"
                        id="title"
                        name="title"
                        required
                        placeholder="Enter category name (e.g., Technology, Sports, News)">
                    <small class="form-text text-muted">
                        Choose a descriptive name for this category
                    </small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Category
                    </button>
                    <a href="/admin/categories" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>