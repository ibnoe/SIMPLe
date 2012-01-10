<div class="content">

    <h1>Forum</h1>
    <?php $forum = $forums->row() ?>
    <div>

        <h2><?php echo $forum->judul_forum ?></h2>

        <em>Tanggal: <?php echo date('d-m-Y', strtotime($forum->tanggal)) ?></em>

        <div>
            <?php echo $forum->isi_forum ?>
        </div>

        <div>
            File: 
            <?php echo anchor('upload/forum/' . $forum->file, $forum->file)?>
        </div>

    </div>
    
    <hr/>

    <h2>Balas</h2>
    <?php 
    $data['kat_forum']    = NULL;
    $data['id_parent']    = $forum->id_forum;
    $data['id_kat_forum'] = $forum->id_kat_forum;
    $data['judul_forum']  = 'Balas: ' . $forum->judul_forum;
    $data['referrer']     = 'frontdesk/man_forum/view/' . $forum->id_forum;
    $this->load->view('frontdesk/man_forum/form', $data) 
    ?>
    
    <hr/>
    
    <h2><?php echo 'Ada ' . count($childs) . ' balasan' ?></h2>
    <?php foreach ($childs as $child): ?>
        <blockquote style="padding-left: 5px; margin: 20px 0;">

        <h3><?php echo $child->judul_forum ?></h3>

        <em>Tanggal: <?php echo date('d-m-Y', strtotime($child->tanggal)) ?></em>

        <div>
            <?php echo $child->isi_forum ?>
        </div>

        </blockquote>
    <?php endforeach ?>
</div>