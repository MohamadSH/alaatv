@if(isset($favActionUrl) && isset($unfavActionUrl) && isset($isFavored))
    <input type="hidden" name="favoriteActionUrl" value="{{ $favActionUrl }}">
    <input type="hidden" name="unFavoriteActionUrl" value="{{ $unfavActionUrl }}">
    
    <div class="btnFavorite">
        <img class="btnFavorite-on {{ ($isFavored) ? '' : 'a--d-none' }}" src="https://cdn.alaatv.com/upload/fav-on.svg" width="50">
        <img class="btnFavorite-off {{ ($isFavored) ? 'a--d-none' : '' }}" src="https://cdn.alaatv.com/upload/fav-off.svg" width="50">
    </div>
@endif