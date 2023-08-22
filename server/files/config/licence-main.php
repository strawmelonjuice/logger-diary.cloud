<div class="AddEntryForm">
            <a href="https://github.com/strawmelonjuice/logger-diary.online/blob/main/Licence.md" target="_blank"><h2><span class="emojis">📜</span>&nbsp;<text class="translatable" data-translation_id="78"></text></h2></a>
        <p align="center"><big><text class="translatable" data-translation_id="77">For</text> Logger, <i><?php echo $_SESSION['LANG'][2] ?></i>!</big></p>
</div>
        <div class="readback settingsmain">
            <div align="center" style="width: 90%">
            <p class="alert"><text class="translatable" data-translation_id="10"></text></p>
                <?php
                $Parsedown = new Parsedown();
                $HTML = $Parsedown->text(file_get_contents(__DIR__ . "/../../Licence.md"));
                echo $HTML;
                ?>
            </div>
        </div>
        <footer class="infofooter">
            <hr>
            <p><?php echo $LoggerInfo; ?></p>
        </footer>