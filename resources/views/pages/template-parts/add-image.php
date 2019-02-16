<form id="addImageStory" class="addLinksForm" action="http://gpt.website/image" method="POST" enctype="multipart/form-data" role="form">
    <input name="_token" value="dj24FZZ0xFWQKGfwr56QQ7OsezvjGSygNFZY7Pmz" type="hidden">
    <label for="storyTitle">Title</label>
    <div class="form-group">
        <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <div class="input-group input-file" name="image">
			<span class="input-group-btn">
        		<button class="btn btn-default btn-choose" type="button">Choose</button>
    		</span>
            <input type="text" class="form-control" placeholder='Choose a file...' />
            <span class="input-group-btn">
       			 <button class="btn btn-warning btn-reset" type="button">Reset</button>
    		</span>
        </div>
    </div>
    <div class="form-group">
        <label for="storyCategory">Category</label>
        <select name="category" id="storyCategory" class="pull-left selectpicker" data-live-search="true" style="margin-bottom: 15px;" tabindex="-98">
            <option value="Travel" data-tokens="Travel">Travel</option>
            <option value="Business" data-tokens="Business">Business</option>
            <option value="Communication" data-tokens="Communication">Communication</option>
            <option value="Computer" data-tokens="Computer">Computer</option>
            <option value="How to" data-tokens="How to">How to</option>
            <option value="Tech" data-tokens="Tech">Tech</option>
        </select>
    </div>
    <div class="form-group">
        <label for="storyDesc">Description</label>
        <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label>Tags</label>
        <input name="tags" id="tags" class="form-control" placeholder="a,ab,abc" type="text">
    </div>
    <input name="user_id" value="3" type="hidden">
    <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>

</form>