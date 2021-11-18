<div id="game-selector">
    <input type="text"
           aria-label="Name of the game" placeholder="Name of the game"
           id="game-name" name="game-name"
           autocomplete="off" <?php echo (isset($required) && $required) ? 'required' : ''; ?>>

    <ul id="game-autocompleter"></ul>
</div>

<script src="/static/js/gameSelector.js"></script>
