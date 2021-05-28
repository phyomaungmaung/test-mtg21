<form action="{{ url('videos/upload') }}" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="exampleInputVideo">Upload Video</label>
        <input type="file" name="video" id="exampleInputVideo" />
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-default">Submit</button>
</form>