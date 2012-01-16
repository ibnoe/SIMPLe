<style type="text/css">
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
        /* add padding to account for vertical scrollbar */
        padding-right: 20px;
    }

    .identitas label {
        width: 100px;
        display: inline-block;
    }

    #kl label {
        width: 180px;
        display: inline-block;
    }
</style>
<script type="text/javascript">
    $(function ($) {

        function split(val) {
            return val.split(/,\s*/);
        }

        function extractLast(term) {
            return split(term).pop();
        }


        $(function () {

            $('#nama_kl').chosen().change(function(){
                var nama_kl = $(this).val();
                $.get('<?php echo site_url('helpdesk/identitas_satker/cari_kl/') ?>', {id_kementrian:nama_kl}, function (response) {
                    console.log(response);
                    $('#eselon').html(response);
                    $('#eselon').trigger('liszt:updated');
                    $('#kode_satker').removeAttr('disabled');
                })
            })


            $('#eselon').chosen().change(function () {
                id_kementrian = substr($('#nama_kl').val(), 0, 3);
                url = '<?php echo site_url('frontdesk/form_revisi_anggaran/anggaran') ?>/' + id_kementrian;
                console.log(url);
                $.get(url, function (response) {
                    $('#anggaran').html('A' + response);
                });

                url = '<?php echo site_url('frontdesk/form_revisi_anggaran/cari_satker') ?>/' + id_kementrian + '/' + $(this).val();
                console.log(url);
                $.get(url, function(response){
                    $('#kode_satker').html(response);
                    $('#kode_satker').trigger('liszt:updated');
                    console.log(response);
                });
            });


            $('form').submit(function () {
                data = $(this).serialize();
//            console.log(data);
//            return false;
            })


            // Daftar Kementrian Statis aja biar cepet
            var kementrian_list = {};
            kementrian_list.results = [
            <?php
            foreach ($kementrian->result() as $value) {
                echo sprintf("{id:\"%s\",name:\"%s\"},\n", $value->id_kementrian, $value->id_kementrian . ' - ' . $value->nama_kementrian);
            }
            ?>
            ];
            kementrian_list.total = kementrian_list.results.length;

            // Tambah Dokumen Lainnya
            $('#other-doc-btn').live('click', function () {
                $('#other-docs').append('<p><input type="text" name="dokumen_lainnya[]"/></p>');
                $('#other-docs input:last-child').focus();
            })

            // Jangan sampai udah banyak ngetik,
            // ehh... ternyata kepencet enter.
            // Bubar semuanya, ngetik dari awal lagi deh (T_T)
            $('form').keypress(function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                }

            })

            $('#tanggal_surat_usulan').datepicker({
                dateFormat:'dd-mm-yy'
            });
        })

        $(".chzn-select").chosen();
    })
</script>

<div class="content">

    <h1>Form Revisi Anggaran</h1>

    <div class="clear"></div>

    <?php
    $errors = validation_errors();
    if (!empty($errors)) {
        echo notification(validation_errors(), 'Error', 'red');
    }
    ?>

    <?php echo form_open('frontdesk/form_revisi_anggaran/save_identitas', 
        array('id'   => 'identitas_kl')) ?>

    <?php echo form_hidden('tipe', 'kl') ?>

    <fieldset id="kl">
        <legend>Kementrian / Lembaga</legend>


        <p>

        <div style="float: left;">
            <label class="align-right">Nomor Surat Usulan</label>
            <input type="text" id="nomor_surat_usulan" name="nomor_surat_usulan" value="<?php echo set_value('nomor_surat_usulan') ?>"/>
        </div>
        <div style="float: right; margin-left: 50px;">
            <label class="align-right">Tanggal Surat Usulan</label>
            <input type="text" id="tanggal_surat_usulan" name="tanggal_surat_usulan" value="<?php echo set_value('tanggal_surat_usulan') ?>"/>
        </div>

        <div id="anggaran" style="padding: 20px; display: inline-block; float: right; font-size: 24px;"></div>
        
        <div class="clear"></div>
        </p>

        <p>
            <label class="align-right">Kode - Nama K/L</label>
            <select name="nama_kl" id="nama_kl" type="text" class="chzn-select" data-placeholder="Pilih nama K/L" style="width: 700px;">
                <?php
                foreach ($kementrian->result() as $value) {
                    echo sprintf("<option value='%s'>%s</option>", $value->id_kementrian, $value->id_kementrian . ' - ' . $value->nama_kementrian);
                }
                ?>
            </select>
        </p>

        <p>
            <label class="align-right">Nama Eselon 1</label>
            <select id="eselon" name="eselon" class="kl chzn-select" value="<?php echo set_value('eselon') ?>" style="width: 700px;">
            </select>
        </p>

        <p class="kode_satker_p">
            <label class="align-right">Kode - Nama Satker</label>
            <select name="kode_satker" id="kode_satker" class="kl chzn-select" multiple style="width: 700px;">
            </select>
        </p>

    </fieldset>

    <fieldset style="float: left; margin-right: 10px; width: 47%;" class="identitas">
        <legend>Identitas</legend>
        <p>
            <label class="aligned">NIP</label>
            <input type="text" name="nip" size="30" value="<?php echo set_value('nip') ?>">
        </p>

        <p>
            <label class="aligned">Nama</label>
            <input type="text" name="nama_petugas" size="30" value="<?php echo set_value('nama_petugas') ?>">
        </p>

        <p>
            <label class="aligned">Jabatan Petugas</label>
            <input type="text" name="jabatan_petugas" size="30" value="<?php echo set_value('jabatan_petugas') ?>">
        </p>

        <p>
            <label class="aligned">Nomor HP</label>
            <input type="text" name="no_hp" size="30" value="<?php echo set_value('no_hp') ?>">
        </p>

        <p>
            <label class="aligned">Telepon Kantor</label>
            <input type="text" name="no_kantor" size="30" value="<?php echo set_value('no_kantor') ?>">
        </p>

        <p>
            <label class="aligned">E-mail</label>
            <input type="email" name="email" size="30" value="<?php echo set_value('email') ?>">
        </p>
    </fieldset>

    <fieldset style="float: right; width: 47%;">
        <legend>Kelengkapan Dokumen</legend>

        <div style="overflow: auto; margin: 0;">
            <?php foreach ($kelengkapan_dokumen->result() as $value): ?>

            <?php if ($value->id_kelengkapan != 0): ?>
                <p>
                    <label>
                        <input type="checkbox" name="dokumen[<?php echo $value->id_kelengkapan ?>]"/>
                        <?php echo $value->nama_kelengkapan ?>
                    </label>
                </p>
                <?php endif ?>
            <?php endforeach ?>

            <p id="other-docs"></p>

            <input type="button" id="other-doc-btn" class="button blue-pill" value="Tambah Dokumen Lain"/>
        </div>
    </fieldset>

    <div style="float: right; width: 47%; text-align: center; margin-top: 20px;">
        <a style="padding: 20px 40px; font-size: 1.5em; font-weight: bold" class="button green" onclick="$('#identitas_kl').submit()">Kirim</a>
        <a style="padding: 20px 40px; font-size: 1.5em; font-weight: bold" href="<?php echo site_url('/frontdesk/form_revisi_anggaran') ?>" class="button gray-pill">Reset</a>
    </div>

    </form>
</div>
