<div class="card mx-auto my-2">
    <div class="card-body">
    <h5 class="card-title">Nuovo Todo</h5>
        <form action="add_todo.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Titolo ToDo</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Aggiungi</button>
        </form>
    </div>

</div>