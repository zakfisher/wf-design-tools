<div id="batch-rename-storefronts" class="page">

    <h3><span class="label label-danger">Batch Rename Storefronts</span></h3>

    <h2 class="pull-left">Centre:</h2>
    <div class="col-xs-3 pull-left">
        <select class="form-control" name="centre">
            <?php foreach ($this->centres as $c): ?>
                <option value="<?=$c?>"<?=$c===$this->centre?' selected':''?>><?=$c?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Buttons -->
    <a class="btn btn-default pull-left view-centre" href="?task=batch-rename-storefronts&centre=<?=$this->centre?>" style="margin-right:10px;">View Centre</a>
    <a class="btn btn-primary pull-right view-centre" href="?task=manually-rename-storefronts&centre=<?=$this->centre?>" style="margin-left:10px;">Manual Rename</a>
    <a class="btn btn-success pull-right" href="?task=batch-rename-storefronts&centre=<?=$this->centre?>&rename=true" style="margin-left:10px;">Run Batch Rename</a>

    <!-- Stats -->
    <ol class="breadcrumb pull-right">
        <li><b><?=count($this->storefronts)?></b> rows remaining</li>
        <li><b><?=count($this->files)?></b> files unchanged</li>
    </ol>

    <?php if (count($this->files) === 0): ?>
    <p style="clear:both;">There are no files to rename.</p>
    <?php else: ?>
    <!-- Tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#not-renamed" class="not-renamed" data-toggle="tab">Not Renamed</a></li>
        <li><a href="#renamed" class="renamed" data-toggle="tab">Renamed</a></li>
    </ul>

    <!-- Tables -->
    <div class="tab-content">
        <?php $ignoredProps = array('renamed'); ?>
        <div class="tab-pane active" id="not-renamed">
            <table class="table table-bordered not-renamed table-striped">
                <thead>
                <tr>
                    <?php foreach ($this->storefronts[0] as $k => $v): ?>
                        <?php if (in_array($k, $ignoredProps)) continue;?>
                        <th><?=$k?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($this->storefronts as $s): ?>
                    <?php if ($s['renamed'] == 'yes') continue; ?>
                    <tr>
                        <?php foreach ($s as $k => $prop): ?>
                            <?php if (in_array($k, $ignoredProps)) continue;?>
                            <td><?=$prop?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php $ignoredProps = array('renamed', 'sourcefile', 'matches', 'prefix'); ?>
        <div class="tab-pane" id="renamed">
            <table class="table table-bordered renamed table-striped">
                <thead>
                <tr>
                    <?php foreach ($this->storefronts[0] as $k => $v): ?>
                        <?php if (in_array($k, $ignoredProps)) continue;?>
                        <th><?=$k?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($this->storefronts as $s): ?>
                    <?php if ($s['renamed'] == 'no') continue; ?>
                    <tr>
                        <?php foreach ($s as $k => $prop): ?>
                            <?php if (in_array($k, $ignoredProps)) continue;?>
                            <td><?=$prop?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div>