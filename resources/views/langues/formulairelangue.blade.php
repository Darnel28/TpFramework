<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="preload" href="../css/adminlte.css" as="style" />
    <!--end::Accessibility Features-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../css/adminlte.css" />
    <title>Formulaire</title>
</head>
<body>
    <div class="card card-warning card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Formulaire Langue</div></div>
                  <!--end::Header-->
                  <!--begin::Form-->
                  <form>
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="row mb-3">
                        <label for="nomlang" class="col-sm-1 col-form-label">Nom de la langue</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="nomlang" />
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="codelang" class="col-sm-1 col-form-label">Code de la langue</label>
                         <div class="col-sm-10">
                          <input type="text" class="form-control" id="codelang" />
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="description" class="col-sm-1 col-form-label">Description</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="description" />
                        </div>
                      </div>
                        
                      </div>
                     
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn ">Annuler</button>
                      <button type="submit" class="btn btn-success float-end">Enregistrer</button>
                      
                    </div>
                    <!--end::Footer-->
                  </form>
                  <!--end::Form-->
                </div>
</body>
</html>