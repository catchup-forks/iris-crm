<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">{{trans('app.general:general-info') }}</h3>
    </div>

    <div class="box-body">

        <div class="form-group col-sm-6">
            {!! Form::label('name', trans('app.template:name') . " :", ['class' => 'h4 text-purple', 'id' => 'name-label'] ) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <input type="hidden" id="content" name="content"/>

    </div>
</div>

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">{{trans('app.template:customization')}}</h3>
    </div>

    <div class="box-body">
        <div class="col-md-12" style="margin-left:10%">
            <canvas id="c" width="1220" height="1237" style="border: 1px solid rgb(204, 204, 204); position: absolute; width: 1200px; height: 700px; left: 0px; top: 0px; user-select: none;" class="lower-canvas"></canvas>
        </div>
        <div class="row">
            <!-- Submit Field -->
            <div class="form-group col-sm-12">
                {!! Form::submit( trans('app.general:save-changes'), ['class' => 'btn btn-primary']) !!}
                <a href="{!! action('TemplateController@index') !!}" class="btn btn-default">{{trans('app.general:cancel')}}</a>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript">

        $(document).ready(function () {

            $("#name").focusin(function () {

                $('#name-warning').fadeOut(800, function () {
                    $(this).remove();
                });
            });

            let canvas = new fabric.Canvas('c', {
                imageSmoothingEnabled: false,
                enableRetinaScaling: true,

            });

            // create grid
            let grid_size = 15;

            //create elements
            let texts = [
                {
                    value: "Numéro d'identification",
                    iris_type: "label",
                    iris_identifier: "id_number",
                    left: 50,
                    top: 20,
                    fontSize: 20,
                    fontFamily: 'Calibri',
                    fontWeight: 'normal',
                    hasRotatingPoint: false
                },

                {
                    value: "Nom de votre entreprise",
                    iris_type: "label",
                    iris_identifier: "orga_name",
                    left: 50,
                    top: 250,
                    fontSize: 25,
                    fontFamily: 'Calibri',
                    fontWeight: 'bold',
                    hasRotatingPoint: false
                },

                {
                    value: "Statut : XXXX",
                    iris_type: "label",
                    iris_identifier: "orga_stat",
                    left: 50,
                    top: 300,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                    hasRotatingPoint: false
                },

                {
                    value: "N° SIRET : XXX XXX XXX XXXXX",
                    iris_type: "label",
                    iris_identifier: "orga_siret",
                    left: 50,
                    top: 330,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                    hasRotatingPoint: false
                },

                {
                    value: "N° APE : XXXXX",
                    iris_type: "label",
                    iris_identifier: "orga_ape",
                    left: 50,
                    top: 360,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                    hasRotatingPoint: false
                },

                {
                    value: "Email : mail@domain.com",
                    iris_type: "label",
                    iris_identifier: "orga_email",
                    left: 50,
                    top: 390,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                    hasRotatingPoint: false
                },

                {
                    value: "Adresse : Ligne 1 + Ligne 2 + CP + Ville + Pays",
                    iris_type: "label",
                    iris_identifier: "orga_address",
                    left: 50,
                    top: 420,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                    hasRotatingPoint: false
                },

                {
                    value: "N° TVA : FRXX XXX XXX XXX",
                    iris_type: "label",
                    iris_identifier: "orga_tva",
                    left: 50,
                    top: 450,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                    hasRotatingPoint: false
                },

                {
                    value: "Nom du client",
                    iris_type: "label",
                    iris_identifier: "client_name",
                    left: 850,
                    top: 250,
                    fontSize: 25,
                    fontFamily: 'Calibri',
                    hasRotatingPoint: false,
                    fontWeight: 'bold'
                },


                {
                    value: "Statut client : XXXX",
                    iris_type: "label",
                    iris_identifier: "client_stat",
                    left: 850,
                    top: 300,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                    hasRotatingPoint: false
                },

                {
                    value: "N° SIRET client : XXX XXX XXX XXXXX",
                    iris_type: "label",
                    iris_identifier: "client_siret",
                    left: 850,
                    top: 330,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                },

                {
                    value: "N° APE client : XXXXX",
                    iris_type: "label",
                    iris_identifier: "client_ape",
                    left: 850,
                    top: 360,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                },

                {
                    value: "Email client : mail@domain.com",
                    iris_type: "label",
                    iris_identifier: "client_email",
                    left: 850,
                    top: 390,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                },

                {
                    value: "Adresse client : Ligne 1 + Ligne 2 ...",
                    iris_type: "label",
                    iris_identifier: "client_address",
                    left: 850,
                    top: 420,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                },

                {
                    value: "N° TVA client : FRXX XXX XXX XXX",
                    iris_type: "label",
                    iris_identifier: "client_tva",
                    left: 850,
                    top: 450,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                },

                {
                    value: "Date : Fait le JJ Mois AAAA à XXXXXXX",
                    iris_type: "label",
                    iris_identifier: "date",
                    left: 850,
                    top: 1000,
                    fontSize: 19,
                    fontFamily: 'Calibri',
                },


            ];

            texts.forEach(function (textObject) {
                canvas.add(new fabric.Text(textObject.value, textObject));
            });


            fabric.Image.fromURL("{{asset("img/logo-placeholder.png")}}", function (image) {
                let logoImage = image.set({
                    iris_type: "image",
                    iris_identifier: "orga_logo",
                    left: 610,
                    top: 150,
                    originX: "center",
                    originY: "center",
                    hasRotatingPoint: false
                });
                canvas.add(logoImage);

            });

            fabric.Image.fromURL("{{asset("img/fr-content-ph.png")}}", function (image) {
                let contentImage = image.set({
                    iris_type: "content",
                    iris_identifier: "content_ph",
                    left: 610,
                    top: 700,
                    originX: "center",
                    originY: "center",
                    hasBorders: false,
                    hasControls: false,
                    hasRotatingPoint: false
                });
                canvas.add(contentImage);

            });

            // add delete button

            function addDeleteBtn(x, y) {
                $(".deleteBtn").remove();
                var btnLeft = x - 10;
                var btnTop = y - 10;
                var deleteBtn = '<img src="{{asset("img/close-button.png")}}" class="deleteBtn" style="position:absolute;top:' + btnTop + 'px;left:' + btnLeft + 'px;cursor:pointer;width:20px;height:20px;"/>';
                $(".canvas-container").append(deleteBtn);
            }

            canvas.on('object:selected', function (e) {
                if (e.target.iris_identifier !== "content_ph") {
                    addDeleteBtn(e.target.oCoords.tr.x, e.target.oCoords.tr.y);
                }
            });

            canvas.on('mouse:down', function (e) {
                if (!canvas.getActiveObject()) {
                    $(".deleteBtn").remove();
                }
            });

            canvas.on('object:modified', function (e) {
                if (e.target.iris_identifier !== "content_ph") {
                    addDeleteBtn(e.target.oCoords.tr.x, e.target.oCoords.tr.y);
                }
            });

            canvas.on('object:scaling', function (e) {
                $(".deleteBtn").remove();
            });
            canvas.on('object:moving', function (e) {
                $(".deleteBtn").remove();
            });
            canvas.on('object:rotating', function (e) {
                $(".deleteBtn").remove();
            });
            $(document).on('click', ".deleteBtn", function () {
                if (canvas.getActiveObject()) {
                    canvas.remove(canvas.getActiveObject());
                    $(".deleteBtn").remove();
                }
            });

            // snap to grid

            canvas.on('object:moving', function (options) {
                options.target.set({
                    left: Math.round(options.target.left / grid_size) * grid_size,
                    top: Math.round(options.target.top / grid_size) * grid_size
                });
            });

            // JSON without default values
            canvas.includeDefaultValues = false;

            let json = canvas.toJSON(['iris_identifier', 'iris_type']);

            $('#content').val(JSON.stringify(json));


            $("#template-form").submit(function (e) {

                e.preventDefault();

                if ($('#name').val() == "") {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $('#name-label').prepend('<p class="h5 text-red animated flash" id="name-warning"> Un nom doit être renseigné pour ce template</p>');
                    return false;
                }

                let json = canvas.toJSON(['iris_identifier', 'iris_type']);
                $('#content').val(JSON.stringify(json));

                this.submit();
            });

        })
        ;


    </script>


@endsection