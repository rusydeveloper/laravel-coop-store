@extends('layouts.tenant')

@section('content')
<style type="text/css">
.card-body{
    font-size: 12pt;
    text-align: left
}
</style>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Business</div>
                <div class="card-body">
                    <form method="POST" action="/tenant/business/update" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="unique_id" value="{{$business->unique_id}}">
                        <div class="form-group row">
                            <div class="col-md-12" style="text-align: center">
                                <div class="img-container">
                                    @empty($picture)
                                     <img src="{{asset('storage/businesses/business_default.jpg')}}" alt="no picture" width="200">
                                    @else
                                   <img src="{{asset('storage/businesses/'.$picture->name)}}" alt="no picture" width="200" height="200">
                                    @endempty
                                    <br><br>
                                    <p><b>Edit Picture</b></p>
                                    <input type="file" name="picture_file" value="">
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Business Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$business->name}}" required>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact" class="col-md-4 col-form-label text-md-right">Phone Number</label>
                            <div class="col-md-6">
                                <input id="contact" type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact"  value="{{$business->contact}}" required>
                                @if ($errors->has('contact'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contact') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Restaurant Category</label>

                            <div class="col-md-6">
                                <select id="category" name="category" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}">
                                     <option value="{{$business->category}}" selected>{{$business->category}}</option>
                                    <option value="Indonesian">Indonesia</option>
                                    <option value="West">West</option>
                                    <option value="European">European</option>
                                    <option value="Asian">Asian</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Japanese">Japanese</option>
                                    <option value="Korean">Korean</option>
                                    <option value="Vietnamese">Vietnamese</option>
                                    <option value="Mediterranean">Arabic</option>
                                    <option value="Italian">Italian</option>
                                    <option value="Campuran">Campuran</option>
                                </select>

                                @if ($errors->has('category'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="col-form-label text-md-right">Description</label>
                            <textarea class="form-control" rows="2" id="description" name="description" required>{{$business->description}}</textarea>
                        </div>
                        <fieldset>
                            <legend>Location</legend>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" rows="2" id="address" name="address" required>{{$business->address}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="village">Village (Kelurahan)</label>
                                <input type="text" name="village" class="form-control" id="village" value="{{$business->village}}" required>
                            </div>
                            <div class="form-group">
                                <label for="district">District (Kecamatan)</label>
                                <input type="text" name="district" class="form-control" id="district" value="{{$business->district}}" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <select id="city" name="city"  type="text" class="form-control" data-show-subtext="true" data-live-search="true" data-size="5" autofocus required>
                                    <option value="{{$business->city}}">{{$business->city}}</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Jakarta Utara">Jakarta Utara</option>
                                    <option value="Jakarta Selatan">Jakarta Selatan</option>
                                    <option value="Jakarta Barat">Jakarta Barat</option>
                                    <option value="Jakarta Timur">Jakarta Timur</option>
                                    <option value="Jakarta Pusat">Jakarta Pusat</option>
                                    <option value="Aek Kanopan">Aek Kanopan</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Airmadidi">Airmadidi</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="Ambarawa">Ambarawa</option>
                                    <option value="Ambon">Ambon</option>
                                    <option value="Ampana">Ampana</option>
                                    <option value="Amurang">Amurang</option>
                                    <option value="Andolo">Andolo</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Anyer">Anyer</option>
                                    <option value="Arga Makmur">Arga Makmur</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Arosuka">Arosuka</option>
                                    <option value="Asmat">Asmat</option>
                                    <option value="Atambua">Atambua</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Baa">Baa</option>
                                    <option value="Badung">Badung</option>
                                    <option value="Baganbatu">Baganbatu</option>
                                    <option value="Bagansiapiapi">Bagansiapiapi</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bajawa">Bajawa</option>
                                    <option value="Balige">Balige</option>
                                    <option value="Balikpapan">Balikpapan</option>
                                    <option value="Banda Aceh">Banda Aceh</option>
                                    <option value="Bandar Lampung">Bandar Lampung</option>
                                    <option value="Bandar Seri Bintan">Bandar Seri Bintan</option>

                                    <option value="Banggai">Banggai</option>
                                    <option value="Bangil">Bangil</option>
                                    <option value="Bangkalan">Bangkalan</option>
                                    <option value="Bangkinang">Bangkinang</option>
                                    <option value="Bangko">Bangko</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Bangli">Bangli</option>
                                    <option value="Bangli">Bangli</option>
                                    <option value="Banjar (Jawa Barat)">Banjar (Jawa Barat)</option>
                                    <option value="Banjarbaru">Banjarbaru</option>
                                    <option value="Banjarmasin">Banjarmasin</option>
                                    <option value="Banjarnegara">Banjarnegara</option>
                                    <option value="Bantaeng">Bantaeng</option>
                                    <option value="Bantul">Bantul</option>
                                    <option value="Banyuasin">Banyuasin</option>
                                    <option value="Banyumas">Banyumas</option>
                                    <option value="Banyuwangi">Banyuwangi</option>
                                    <option value="Barabai">Barabai</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Barru">Barru</option>
                                    <option value="Batam">Batam</option>
                                    <option value="Batang">Batang</option>
                                    <option value="Batang Tarang">Batang Tarang</option>
                                    <option value="Batu">Batu</option>
                                    <option value="Batulicin">Batulicin</option>
                                    <option value="Baturaja">Baturaja</option>
                                    <option value="Batusangkar">Batusangkar</option>
                                    <option value="Bau-Bau">Bau-Bau</option>
                                    <option value="Bekasi">Bekasi</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Bengkalis">Bengkalis</option>
                                    <option value="Bengkayang">Bengkayang</option>
                                    <option value="Bengkulu">Bengkulu</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Benteng">Benteng</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Biak">Biak</option>
                                    <option value="Bima">Bima</option>
                                    <option value="Binjai">Binjai</option>
                                    <option value="Bintuhan">Bintuhan</option>
                                    <option value="Bintuni">Bintuni</option>
                                    <option value="Bireuen">Bireuen</option>
                                    <option value="Bitung">Bitung</option>
                                    <option value="Blambangan Umpu">Blambangan Umpu</option>
                                    <option value="Blang Kejeren">Blang Kejeren</option>
                                    <option value="Blangpidie">Blangpidie</option>
                                    <option value="Blitar">Blitar</option>
                                    <option value="Blora">Blora</option>
                                    <option value="Bogor">Bogor</option>
                                    <option value="Bojonegoro">Bojonegoro</option>
                                    <option value="Bolaang Uki">Bolaang Uki</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bondowoso">Bondowoso</option>
                                    <option value="Bontang">Bontang</option>
                                    <option value="Boroko">Boroko</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Boven Digoel">Boven Digoel</option>
                                    <option value="Boyolali">Boyolali</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="Brebes">Brebes</option>
                                    <option value="Brunei">Brunei</option>
                                    <option value="Bukittinggi">Bukittinggi</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Bulukumba">Bulukumba</option>
                                    <option value="Bumiayu">Bumiayu</option>
                                    <option value="Bungku">Bungku</option>
                                    <option value="Buntok">Buntok</option>
                                    <option value="Buol">Buol</option>
                                    <option value="Buranga">Buranga</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Buru">Buru</option>
                                    <option value="Buru Selatan">Buru Selatan</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cabo Verde">Cabo Verde</option>
                                    <option value="Calang">Calang</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Caruban">Caruban</option>
                                    <option value="Central African Republic (CAR)">Central African Republic (CAR)</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Ciamis">Ciamis</option>
                                    <option value="Cianjur">Cianjur</option>
                                    <option value="Cibinong">Cibinong</option>
                                    <option value="Cikampek">Cikampek</option>
                                    <option value="Cikarang">Cikarang</option>
                                    <option value="Cilacap">Cilacap</option>
                                    <option value="Cilegon">Cilegon</option>
                                    <option value="Cirebon">Cirebon</option>
                                    <option value="Cliquers">Cliquers</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Curup">Curup</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Daik">Daik</option>
                                    <option value="Deiyai">Deiyai</option>
                                    <option value="Demak">Demak</option>
                                    <option value="Democratic Republic of theCongo">Democratic Republic of theCongo</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Denpasar">Denpasar</option>
                                    <option value="Denpasar">Denpasar</option>
                                    <option value="Depok">Depok</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dogiyai">Dogiyai</option>
                                    <option value="Dolok Marawa">Dolok Marawa</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="Dompu">Dompu</option>
                                    <option value="Donggala">Donggala</option>
                                    <option value="Dumai">Dumai</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Ende">Ende</option>
                                    <option value="Enrekang">Enrekang</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Eswatini (formerly Swaziland)">Eswatini (formerly Swaziland)</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Fakfak">Fakfak</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Garut">Garut</option>
                                    <option value="Gedong Tataan">Gedong Tataan</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gianyar">Gianyar</option>
                                    <option value="Gorontalo">Gorontalo</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Gresik">Gresik</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option value="Gunung Sitoli">Gunung Sitoli</option>
                                    <option value="Gunung Sugih">Gunung Sugih</option>
                                    <option value="Gunung Tua">Gunung Tua</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Halmahera Barat">Halmahera Barat</option>
                                    <option value="Halmahera Selatan">Halmahera Selatan</option>
                                    <option value="Halmahera Tengah">Halmahera Tengah</option>
                                    <option value="Halmahera Timur">Halmahera Timur</option>
                                    <option value="Halmahera Utara">Halmahera Utara</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="Idi Rayeuk">Idi Rayeuk</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Indralaya">Indralaya</option>
                                    <option value="Indramayu">Indramayu</option>
                                    <option value="Intan Jaya">Intan Jaya</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Jambi">Jambi</option>
                                    <option value="Jantho">Jantho</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jayapura">Jayapura</option>
                                    <option value="Jayapura (kota)">Jayapura (kota)</option>
                                    <option value="Jayawijaya">Jayawijaya</option>
                                    <option value="Jember">Jember</option>
                                    <option value="Jeneponto">Jeneponto</option>
                                    <option value="Jepara">Jepara</option>
                                    <option value="Jombang">Jombang</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kabanjahe">Kabanjahe</option>
                                    <option value="Kaimana">Kaimana</option>
                                    <option value="Kajen">Kajen</option>
                                    <option value="Kalabahi">Kalabahi</option>
                                    <option value="Kalianda">Kalianda</option>
                                    <option value="Kandangan">Kandangan</option>
                                    <option value="Karang Baru">Karang Baru</option>
                                    <option value="Karang Tinggi">Karang Tinggi</option>
                                    <option value="Karanganyar">Karanganyar</option>
                                    <option value="Karangasem">Karangasem</option>
                                    <option value="Kawangkoan">Kawangkoan</option>
                                    <option value="Kayu Agung">Kayu Agung</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kebumen">Kebumen</option>
                                    <option value="Kediri">Kediri</option>
                                    <option value="Keerom">Keerom</option>
                                    <option value="Kefamenanu">Kefamenanu</option>
                                    <option value="Kendal">Kendal</option>
                                    <option value="Kendari">Kendari</option>
                                    <option value="Kendawangan">Kendawangan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kepahiang">Kepahiang</option>
                                    <option value="Kepanjen">Kepanjen</option>
                                    <option value="Kepulauan Aru">Kepulauan Aru</option>
                                    <option value="Kepulauan Sula">Kepulauan Sula</option>
                                    <option value="Kepulauan Yapen">Kepulauan Yapen</option>
                                    <option value="Ketapang">Ketapang</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Kisaran">Kisaran</option>
                                    <option value="Klaten">Klaten</option>
                                    <option value="Klungkung">Klungkung</option>
                                    <option value="Koba">Koba</option>
                                    <option value="Kolaka">Kolaka</option>
                                    <option value="Kosovo">Kosovo</option>
                                    <option value="Kota Agung">Kota Agung</option>
                                    <option value="Kota Palabuhanratu">Kota Palabuhanratu</option>
                                    <option value="Kota Pinang">Kota Pinang</option>
                                    <option value="Kota Raha">Kota Raha</option>
                                    <option value="Kotabaru">Kotabaru</option>
                                    <option value="Kotabumi">Kotabumi</option>
                                    <option value="Kotamobagu">Kotamobagu</option>
                                    <option value="Kraksaan">Kraksaan</option>
                                    <option value="Kuala Kapuas">Kuala Kapuas</option>
                                    <option value="Kuala Kurun">Kuala Kurun</option>
                                    <option value="Kuala Pembuang">Kuala Pembuang</option>
                                    <option value="Kuala Tungkal">Kuala Tungkal</option>
                                    <option value="Kudus">Kudus</option>
                                    <option value="Kuningan">Kuningan</option>
                                    <option value="Kupang">Kupang</option>
                                    <option value="Kutacane">Kutacane</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kwandang">Kwandang</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Labuhan Bajo">Labuhan Bajo</option>
                                    <option value="Lahat">Lahat</option>
                                    <option value="Lahomi">Lahomi</option>
                                    <option value="Lamongan">Lamongan</option>
                                    <option value="Langsa">Langsa</option>
                                    <option value="Lanny Jaya">Lanny Jaya</option>
                                    <option value="Laos">Laos</option>
                                    <option value="Larantuka">Larantuka</option>
                                    <option value="Lasusua">Lasusua</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Lewoleba">Lewoleba</option>
                                    <option value="Lhokseumawe">Lhokseumawe</option>
                                    <option value="Lhoksukon">Lhoksukon</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libuo Palma">Libuo Palma</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Limapuluh">Limapuluh</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Liwa">Liwa</option>
                                    <option value="Lotu">Lotu</option>
                                    <option value="Lubuk Basung">Lubuk Basung</option>
                                    <option value="Lubuk Bendaharo">Lubuk Bendaharo</option>
                                    <option value="Lubuk Linggau">Lubuk Linggau</option>
                                    <option value="Lubuk Pakam">Lubuk Pakam</option>
                                    <option value="Lubuk Sikaping">Lubuk Sikaping</option>
                                    <option value="Lumajang">Lumajang</option>
                                    <option value="Luwuk">Luwuk</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macedonia (FYROM)">Macedonia (FYROM)</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Madiun">Madiun</option>
                                    <option value="Magelang">Magelang</option>
                                    <option value="Magetan">Magetan</option>
                                    <option value="Majalengka">Majalengka</option>
                                    <option value="Majene">Majene</option>
                                    <option value="Makale">Makale</option>
                                    <option value="Makassar (Ujung Pandang)">Makassar (Ujung Pandang)</option>
                                    <option value="Malang">Malang</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malili">Malili</option>
                                    <option value="Malinau">Malinau</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Maluku Barat Daya">Maluku Barat Daya</option>
                                    <option value="Maluku Tengah">Maluku Tengah</option>
                                    <option value="Maluku Tenggara">Maluku Tenggara</option>
                                    <option value="Maluku Tenggara Barat">Maluku Tenggara Barat</option>
                                    <option value="Mamasa">Mamasa</option>
                                    <option value="Mamberamo Raya">Mamberamo Raya</option>
                                    <option value="Mamberamo Tengah">Mamberamo Tengah</option>
                                    <option value="Mamuju">Mamuju</option>
                                    <option value="Manado (Menado)">Manado (Menado)</option>
                                    <option value="Manggar">Manggar</option>
                                    <option value="Manna">Manna</option>
                                    <option value="Manokwari">Manokwari</option>
                                    <option value="Manokwari Selatan">Manokwari Selatan</option>
                                    <option value="Mappi">Mappi</option>
                                    <option value="Marabahan">Marabahan</option>
                                    <option value="Marisa">Marisa</option>
                                    <option value="Maros">Maros</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martapura">Martapura</option>
                                    <option value="Martapura (Sumatera Selatan)">Martapura (Sumatera Selatan)</option>
                                    <option value="Masamba">Masamba</option>
                                    <option value="Mataram">Mataram</option>
                                    <option value="Maumere">Maumere</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Maybrat">Maybrat</option>
                                    <option value="Mbay">Mbay</option>
                                    <option value="Medan">Medan</option>
                                    <option value="Melonguane">Melonguane</option>
                                    <option value="Mempawah">Mempawah</option>
                                    <option value="Menggala">Menggala</option>
                                    <option value="Mentok">Mentok</option>
                                    <option value="Merauke">Merauke</option>
                                    <option value="Metro">Metro</option>
                                    <option value="Meulaboh">Meulaboh</option>
                                    <option value="Meureude">Meureude</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia">Micronesia</option>
                                    <option value="Mimika">Mimika</option>
                                    <option value="Mojokerto">Mojokerto</option>
                                    <option value="Mojosari">Mojosari</option>
                                    <option value="Moldova">Moldova</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Muara Aman">Muara Aman</option>
                                    <option value="Muara Bulian">Muara Bulian</option>
                                    <option value="Muara Bungo">Muara Bungo</option>
                                    <option value="Muara Dua">Muara Dua</option>
                                    <option value="Muara Enim">Muara Enim</option>
                                    <option value="Muara Sabak">Muara Sabak</option>
                                    <option value="Muara Tebo">Muara Tebo</option>
                                    <option value="Muara Teweh">Muara Teweh</option>
                                    <option value="Muaro Sijunjung">Muaro Sijunjung</option>
                                    <option value="Mukomuko">Mukomuko</option>
                                    <option value="Mungkid">Mungkid</option>
                                    <option value="Myanmar (formerly Burma)">Myanmar (formerly Burma)</option>
                                    <option value="Nabire">Nabire</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nanga Bulik">Nanga Bulik</option>
                                    <option value="Nanga Pinoh">Nanga Pinoh</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nduga">Nduga</option>
                                    <option value="Negara">Negara</option>
                                    <option value="Negara,Bali">Negara,Bali</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Ngabang">Ngabang</option>
                                    <option value="Ngamprah">Ngamprah</option>
                                    <option value="Nganjuk">Nganjuk</option>
                                    <option value="Ngawi">Ngawi</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="North Korea">North Korea</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Nunukan">Nunukan</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Ondong Siau">Ondong Siau</option>
                                    <option value="Pacitan">Pacitan</option>
                                    <option value="Padang">Padang</option>
                                    <option value="Padang Aro">Padang Aro</option>
                                    <option value="Padang Panjang">Padang Panjang</option>
                                    <option value="Padang Sidempuan">Padang Sidempuan</option>
                                    <option value="Pagaralam">Pagaralam</option>
                                    <option value="Painan">Painan</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palabuhanratu">Palabuhanratu</option>
                                    <option value="Palangkaraya">Palangkaraya</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Palembang">Palembang</option>
                                    <option value="Palestine">Palestine</option>
                                    <option value="Palopo">Palopo</option>
                                    <option value="Palu">Palu</option>
                                    <option value="Pamekasan">Pamekasan</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Pandan">Pandan</option>
                                    <option value="Pandeglang">Pandeglang</option>
                                    <option value="Pangkajene">Pangkajene</option>
                                    <option value="Pangkal Pinang">Pangkal Pinang</option>
                                    <option value="Pangkalan Bun">Pangkalan Bun</option>
                                    <option value="Pangkalan Kerinci">Pangkalan Kerinci</option>
                                    <option value="Panguruan">Panguruan</option>
                                    <option value="Paniai">Paniai</option>
                                    <option value="Panyabungan">Panyabungan</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Pare">Pare</option>
                                    <option value="Pare-Pare">Pare-Pare</option>
                                    <option value="Pariaman">Pariaman</option>
                                    <option value="Parigi">Parigi</option>
                                    <option value="Paringin">Paringin</option>
                                    <option value="Parit Malintang">Parit Malintang</option>
                                    <option value="Pasangkayu">Pasangkayu</option>
                                    <option value="Pasir Pengarayan">Pasir Pengarayan</option>
                                    <option value="Pasuruan">Pasuruan</option>
                                    <option value="Pati">Pati</option>
                                    <option value="Payakumbuh">Payakumbuh</option>
                                    <option value="Pegunungan Arfak">Pegunungan Arfak</option>
                                    <option value="Pegunungan Bintang">Pegunungan Bintang</option>
                                    <option value="Pekalongan">Pekalongan</option>
                                    <option value="Pekanbaru">Pekanbaru</option>
                                    <option value="Pelabuhan Ratu">Pelabuhan Ratu</option>
                                    <option value="Pelaihari">Pelaihari</option>
                                    <option value="Pemalang">Pemalang</option>
                                    <option value="Pematang Siantar">Pematang Siantar</option>
                                    <option value="Penajam">Penajam</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Pinrang">Pinrang</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Polewali">Polewali</option>
                                    <option value="Ponorogo">Ponorogo</option>
                                    <option value="Pontianak">Pontianak</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Poso">Poso</option>
                                    <option value="Prabumulih">Prabumulih</option>
                                    <option value="Praya">Praya</option>
                                    <option value="Pringsewu">Pringsewu</option>
                                    <option value="Probolinggo">Probolinggo</option>
                                    <option value="Pulang Pisau">Pulang Pisau</option>
                                    <option value="Pulau Morotai">Pulau Morotai</option>
                                    <option value="Pulau Punjung">Pulau Punjung</option>
                                    <option value="Pulau Taliabu">Pulau Taliabu</option>
                                    <option value="Puncak">Puncak</option>
                                    <option value="Puncak Jaya">Puncak Jaya</option>
                                    <option value="Purbalingga">Purbalingga</option>
                                    <option value="Purukcahu">Purukcahu</option>
                                    <option value="Purwakarta">Purwakarta</option>
                                    <option value="Purwodadi">Purwodadi</option>
                                    <option value="Purwokerto">Purwokerto</option>
                                    <option value="Purworejo">Purworejo</option>
                                    <option value="Putussibau">Putussibau</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Raba">Raba</option>
                                    <option value="Raja Ampat">Raja Ampat</option>
                                    <option value="Ranai">Ranai</option>
                                    <option value="Rangkasbitung">Rangkasbitung</option>
                                    <option value="Rantau">Rantau</option>
                                    <option value="Rantau Prapat">Rantau Prapat</option>
                                    <option value="Rantepao">Rantepao</option>
                                    <option value="Ratahan">Ratahan</option>
                                    <option value="Raya">Raya</option>
                                    <option value="Rembang">Rembang</option>
                                    <option value="Rengat">Rengat</option>
                                    <option value="Republic of the Congo">Republic of the Congo</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Rumbia">Rumbia</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Ruteng">Ruteng</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Sabang">Sabang</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                    <option value="Salak">Salak</option>
                                    <option value="Salatiga">Salatiga</option>
                                    <option value="Samarinda">Samarinda</option>
                                    <option value="Sambas">Sambas</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="Sampang">Sampang</option>
                                    <option value="Sampit">Sampit</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sangatta">Sangatta</option>
                                    <option value="Sanggau">Sanggau</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Sarila">Sarila</option>
                                    <option value="Sarmi">Sarmi</option>
                                    <option value="Sarolangun">Sarolangun</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Sawahlunto">Sawahlunto</option>
                                    <option value="Sebatik">Sebatik</option>
                                    <option value="Sei Rampah">Sei Rampah</option>
                                    <option value="Sekadau">Sekadau</option>
                                    <option value="Sekayu">Sekayu</option>
                                    <option value="Selat Panjang">Selat Panjang</option>
                                    <option value="Selong">Selong</option>
                                    <option value="Semarang">Semarang</option>
                                    <option value="Sendawar">Sendawar</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Sengeti">Sengeti</option>
                                    <option value="Sengkang">Sengkang</option>
                                    <option value="Seram Bagian Barat">Seram Bagian Barat</option>
                                    <option value="Seram Bagian Timur">Seram Bagian Timur</option>
                                    <option value="Serang">Serang</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Siak Sri Indrapura">Siak Sri Indrapura</option>
                                    <option value="Sibolga">Sibolga</option>
                                    <option value="Sibuhuan">Sibuhuan</option>
                                    <option value="Sidayu">Sidayu</option>
                                    <option value="Sidenreng">Sidenreng</option>
                                    <option value="Sidikalang">Sidikalang</option>
                                    <option value="Sidoarjo">Sidoarjo</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Sigi Biromaru">Sigi Biromaru</option>
                                    <option value="Sigli">Sigli</option>
                                    <option value="Simpang Ampek">Simpang Ampek</option>
                                    <option value="Simpang Tiga Redelong">Simpang Tiga Redelong</option>
                                    <option value="Sinabang">Sinabang</option>
                                    <option value="Singaparna">Singaparna</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Singaraja">Singaraja</option>
                                    <option value="Singaraja">Singaraja</option>
                                    <option value="Singkawang">Singkawang</option>
                                    <option value="Singkil">Singkil</option>
                                    <option value="Sinjai">Sinjai</option>
                                    <option value="Sintang">Sintang</option>
                                    <option value="Sipirok">Sipirok</option>
                                    <option value="Situbondo">Situbondo</option>
                                    <option value="Slawi">Slawi</option>
                                    <option value="Sleman">Sleman</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Soe">Soe</option>
                                    <option value="Solok">Solok</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="Soreang">Soreang</option>
                                    <option value="Sorong">Sorong</option>
                                    <option value="Sorong Selatan">Sorong Selatan</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Korea">South Korea</option>
                                    <option value="South Sudan">South Sudan</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sragen">Sragen</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Stabat">Stabat</option>
                                    <option value="Subang">Subang</option>
                                    <option value="Subulussalam">Subulussalam</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suka Makmue">Suka Makmue</option>
                                    <option value="Sukabumi">Sukabumi</option>
                                    <option value="Sukadana">Sukadana</option>
                                    <option value="Sukadana">Sukadana</option>
                                    <option value="Sukamara">Sukamara</option>
                                    <option value="Sukoharjo">Sukoharjo</option>
                                    <option value="Sumbawa Besar">Sumbawa Besar</option>
                                    <option value="Sumber">Sumber</option>
                                    <option value="Sumedang">Sumedang</option>
                                    <option value="Sumenep">Sumenep</option>
                                    <option value="Sungai Penuh">Sungai Penuh</option>
                                    <option value="Sungai Raya">Sungai Raya</option>
                                    <option value="Sungailiat">Sungailiat</option>
                                    <option value="Sunggu Minasa">Sunggu Minasa</option>
                                    <option value="Supiori">Supiori</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Surakarta">Surakarta</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Suwawa">Suwawa</option>
                                    <option value="Swaziland (renamed to Eswatini)">Swaziland (renamed to Eswatini)</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syria">Syria</option>
                                    <option value="Tabanan">Tabanan</option>
                                    <option value="Tabanan">Tabanan</option>
                                    <option value="Tahuna">Tahuna</option>
                                    <option value="Tais">Tais</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Takalar">Takalar</option>
                                    <option value="Takengon">Takengon</option>
                                    <option value="Taliwang">Taliwang</option>
                                    <option value="Tambolaka">Tambolaka</option>
                                    <option value="Tambrauw">Tambrauw</option>
                                    <option value="Tamiang Layang">Tamiang Layang</option>
                                    <option value="Tanah Grogot">Tanah Grogot</option>
                                    <option value="Tangerang">Tangerang</option>
                                    <option value="Tangerang Selatan">Tangerang Selatan</option>
                                    <option value="Tanjung">Tanjung</option>
                                    <option value="Tanjung (Nusa Tenggara Barat)">Tanjung (Nusa Tenggara Barat)</option>
                                    <option value="Tanjung Balai (Sumatera Utara)">Tanjung Balai (Sumatera Utara)</option>
                                    <option value="Tanjung Balai Karimun (Kepulauan Riau)">Tanjung Balai Karimun (Kepulauan Riau)</option>
                                    <option value="Tanjung Enim">Tanjung Enim</option>
                                    <option value="Tanjung Pandan">Tanjung Pandan</option>
                                    <option value="Tanjung Pinang">Tanjung Pinang</option>
                                    <option value="Tanjung Redeb">Tanjung Redeb</option>
                                    <option value="Tanjung Selor">Tanjung Selor</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Tapaktuan">Tapaktuan</option>
                                    <option value="Tarakan">Tarakan</option>
                                    <option value="Tarempa">Tarempa</option>
                                    <option value="Tarutung">Tarutung</option>
                                    <option value="Tasikmalaya">Tasikmalaya</option>
                                    <option value="Tebing Tinggi (Sumatera Selatan)">Tebing Tinggi (Sumatera Selatan)</option>
                                    <option value="Tebing Tinggi (Sumatera Utara)">Tebing Tinggi (Sumatera Utara)</option>
                                    <option value="Tegal">Tegal</option>
                                    <option value="Teluk Bintuni">Teluk Bintuni</option>
                                    <option value="Teluk Dalam">Teluk Dalam</option>
                                    <option value="Teluk Kuantan">Teluk Kuantan</option>
                                    <option value="Teluk Wondama">Teluk Wondama</option>
                                    <option value="Temanggung">Temanggung</option>
                                    <option value="Tembilahan">Tembilahan</option>
                                    <option value="Tenggarong">Tenggarong</option>
                                    <option value="Ternate">Ternate</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Tidore">Tidore</option>
                                    <option value="Tigaraksa">Tigaraksa</option>
                                    <option value="Tilamuta">Tilamuta</option>
                                    <option value="Timor-Leste">Timor-Leste</option>
                                    <option value="Toboali">Toboali</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Toli Toli">Toli Toli</option>
                                    <option value="Tolikara">Tolikara</option>
                                    <option value="Tomohon">Tomohon</option>
                                    <option value="Tondano">Tondano</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trenggalek">Trenggalek</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tual">Tual</option>
                                    <option value="Tuapejat">Tuapejat</option>
                                    <option value="Tuban">Tuban</option>
                                    <option value="Tulungagung">Tulungagung</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Tutuyan">Tutuyan</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ujung Tanjung">Ujung Tanjung</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="Unaaha">Unaaha</option>
                                    <option value="Ungaran">Ungaran</option>
                                    <option value="United Arab Emirates (UAE)">United Arab Emirates (UAE)</option>
                                    <option value="United Kingdom (UK)">United Kingdom (UK)</option>
                                    <option value="United States of America (USA)">United States of America (USA)</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Vatican City (Holy See)">Vatican City (Holy See)</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Waibakul">Waibakul</option>
                                    <option value="Waikabubak">Waikabubak</option>
                                    <option value="Waingapu">Waingapu</option>
                                    <option value="Wanggudu">Wanggudu</option>
                                    <option value="Wangi Wangi">Wangi Wangi</option>
                                    <option value="Waropen">Waropen</option>
                                    <option value="Watampone">Watampone</option>
                                    <option value="Watan Soppeng">Watan Soppeng</option>
                                    <option value="Wates">Wates</option>
                                    <option value="Wlingi">Wlingi</option>
                                    <option value="Wonogiri">Wonogiri</option>
                                    <option value="Wonosari">Wonosari</option>
                                    <option value="Wonosobo">Wonosobo</option>
                                    <option value="Yahukimo">Yahukimo</option>
                                    <option value="Yalimo">Yalimo</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <select id="province" name="province" class="form-control{{ $errors->has('province') ? ' is-invalid' : '' }}">
                                    <option value="{{$business->province}}" selected>{{$business->province}}</option>
                                    <option value="Jawa Barat">Jawa Barat</option>
                                    <option value="Aceh">Aceh</option>
                                    <option value="Sumatera Utara">Sumatera Utara</option>
                                    <option value="Sumatera Barat">Sumatera Barat</option>
                                    <option value="Kepulauan Riau">Kepulauan Riau</option>
                                    <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                                    <option value="Riau">Riau</option>
                                    <option value="Jambi">Jambi</option>
                                    <option value="Bengkulu">Bengkulu</option>
                                    <option value="Sumatera Selatan">Sumatera Selatan</option>
                                    <option value="Lampung">Lampung</option>
                                    <option value="Jawa Tengah">Jawa Tengah</option>
                                    <option value="Jawa Timur">Jawa Timur</option>
                                    <option value="Banten">Banten</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Bali">Bali</option>
                                    <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                                    <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                                    <option value="Kalimantan Barat">Kalimantan Barat</option>
                                    <option value="Kalimantan Timur">Kalimantan Timur</option>
                                    <option value="Kalimantan Utara">Kalimantan Utara</option>
                                    <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                                    <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                                    <option value="Sulawesi Utara">Sulawesi Utara</option>
                                    <option value="Sulawesi Barat">Sulawesi Barat</option>
                                    <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                                    <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                                    <option value="Maluku Utara">Maluku Utara</option>
                                    <option value="Maluku">Maluku</option>
                                    <option value="Papua Barat">Papua Barat</option>
                                    <option value="Papua">Papua</option>
                                </select>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Edit Business
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
