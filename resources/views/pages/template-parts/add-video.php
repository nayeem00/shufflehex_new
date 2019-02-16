<div class="add-video">
    <form id="addNewVideo" class="addLinksForm" action="http://gpt.website/post" method="POST" role="form">
        <input name="_token" value="dj24FZZ0xFWQKGfwr56QQ7OsezvjGSygNFZY7Pmz" type="hidden">

        <label for="storyLink">Link</label>
        <div class="form-group">
            <input name="link" id="storyLink" class="form-control" placeholder="Link" type="text">
        </div>
        <div class="form-group">
            <label for="storyTitle">Title</label>
            <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">
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
            <input name="tags" id="tags" class="form-control" placeholder="tag1,tag2,tag3" type="text">
        </div>
        <input name="user_id" value="3" type="hidden">
        <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>

    </form>
</div>