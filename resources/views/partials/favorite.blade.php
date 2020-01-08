@if(isset($favActionUrl) && isset($unfavActionUrl) && isset($isFavored))
    <input type="hidden" name="favoriteActionUrl" value="{{ $favActionUrl }}">
    <input type="hidden" name="unFavoriteActionUrl" value="{{ $unfavActionUrl }}">

    <div class="btnFavorite">
        <img class="btnFavorite-on  lazy-image {{ ($isFavored) ? '' : 'a--d-none' }}" data-src="https://cdn.alaatv.com/upload/bookmark-on.svg" width="50" height="50">
        <img class="btnFavorite-off lazy-image {{ ($isFavored) ? 'a--d-none' : '' }}" data-src="https://cdn.alaatv.com/upload/bookmark-off.svg" width="50" height="50">
    </div>
@endif
