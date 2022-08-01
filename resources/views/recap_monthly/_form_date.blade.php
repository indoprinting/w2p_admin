<form method="GET">
    <div class="card">
        <div class="card-body">
            <div style="display: flex;justify-content: center;align-items: center">
                <input class="form-control" type="date" name="date1" value="{{ request()->date1 }}">
                <span class="mx-2"> - </span>
                <input class="form-control" type="date" name="date2" value="{{ request()->date2 }}">
                <button class="btn btn-primary ml-2 w-25" type="submit">Submit</button>
            </div>
        </div>
    </div>
</form>
