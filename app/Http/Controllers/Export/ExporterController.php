<?php

namespace App\Http\Controllers\Export;

ini_set('max_execution_time', 0);

use App\Http\Controllers\Controller;
use App\Models\Archives\ArchiveCandidatL1;
use App\Models\Archives\ArchiveCandidatM1;
use App\Models\Archives\ArchiveCandidatM2;
use App\Models\Archives\ArchiveL1;
use App\Models\Archives\ArchiveL2;
use App\Models\Archives\ArchiveL3;
use App\Models\Archives\ArchiveM1;
use App\Models\Archives\ArchiveM2;
use App\Models\Archives\ArchiveMR;
use App\Models\Archives\ArchiveNoteL1;
use App\Models\Archives\ArchiveNoteL2;
use App\Models\Archives\ArchiveNoteL3;
use App\Models\Archives\ArchiveNoteM1;
use App\Models\Archives\ArchiveNoteM2;
use App\Models\Archives\ArchiveNoteMRS;
use App\Models\Attestation;
use App\Models\Candidats\CandidatL;
use App\Models\Candidats\CandidatM;
use App\Models\Candidats\CandidatM2;
use App\Models\Candidats\CandidatM2R;
use App\Models\ElementConstitutif;
use App\Models\Notes\NoteL1;
use App\Models\Notes\NoteL2;
use App\Models\Notes\NoteL3;
use App\Models\Notes\NoteM1;
use App\Models\Notes\NoteM2;
use App\Models\Notes\NoteMR;
use App\Models\Releve;
use App\Models\Students\LicenceOne;
use App\Models\Students\LicenceThree;
use App\Models\Students\LicenceTwo;
use App\Models\Students\MasterOne;
use App\Models\Students\MasterRecherche;
use App\Models\Students\MasterTwo;
use App\Models\UniteEnseignement;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use IntlDateFormatter;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ExporterController extends Controller
{
    private array $request;
    private $condition;
    private $parcours;

    private $matiere;
    private $idMatiere;

    private $anneeNote;

    public function index()
    {
        return view('menu.export');
    }

    public function exportAttestation(Request $request, $lastAttestation)
    {
        $this->request = $request->all();

        if ($request['button'] === "validate") {
            return $this->doExportAttestation($request, $lastAttestation);
        } elseif ($request['button'] === "abort") {
            return redirect()->back();
        }
    }

    public function exportRelever(Request $request, $lastReleve){
        return $this->doExportReleve($request, $lastReleve);
    }

    public function exportBordereau(Request $request, $niveau){
        $role = [
            "Licence" => 'L1, L2, L3 SE en ligne',
            "Master" => 'M1, M2, Master Recherche SE en ligne',
        ];

        $data = [
            'numInscrit' => $request->numInscrit,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'niveau' => $niveau,
            'anneeUnivers' => $request->anneeUnivers,
            'montants' => $request->droit,
            'reference1' => $request->referenceBrd1,
            'reference2' => $request->referenceBrd2,
            'date1' => date("d/m/Y", strtotime($request->dateBrd1)),
            'date2' => date("d/m/Y", strtotime($request->dateBrd2)),
            'date' => $this->formatDateFr(),
            'responsable' => $role[Auth()->user()->role],
            'nomResponsable' => Auth()->user()->name.' '.Auth()->user()->prenom,
        ];

        $pdf = PDF::loadView('pdfExport.bordereau', $data);
        PDF::setOptions([
            "defaultPaperSize" => "a4",
            "dpi" => 150,
        ]);
        return $pdf->stream('brd-' . $request->nom . '-' . $request->prenom . '.pdf');
    }

    /**
     * @param $candidates
     * @return array
     */
    private function setValue($candidates): array
    {
        $i = 0;
        foreach ($candidates as $candidate){
            // if the key exist in candidate
            if(array_key_exists('numInscrit', $candidate)){
                $dataPrime[$i]['Numero'] = $candidate['numInscrit'];
            }

            if(array_key_exists('nom', $candidate)){
                $dataPrime[$i]['Nom'] = $candidate['nom'];

            }

            if(array_key_exists('prenom', $candidate)){
                $dataPrime[$i]['Prenoms'] = $candidate['prenom'];

            }

            if(array_key_exists('dateNaissance', $candidate)){
                $dataPrime[$i]['Date de Naissance']  = date_format(date_create($candidate['dateNaissance']), 'd/m/Y');
            }

            if(array_key_exists('lieuNaissance', $candidate)){
                $dataPrime[$i]['Lieu de Naissance'] = $candidate['lieuNaissance'];
            }


            if(array_key_exists('telCandidat', $candidate)){
                $dataPrime[$i]['Telephone'] = $candidate['telCandidat'];
            }

            if(array_key_exists('cin', $candidate)){
                $dataPrime[$i]['CIN'] = $candidate['cin'];
            }

            if(array_key_exists('genre', $candidate)){
                $dataPrime[$i]['Genre'] = $candidate['genre'];
            }

            if(array_key_exists('cursus', $candidate)){
                $dataPrime[$i]['Cursus'] = $candidate['cursus'];
            }

            if(array_key_exists('centreExamen', $candidate)){
                $dataPrime[$i]["Centre d'Examen"] = $candidate['centreExamen'];
            }

            if(array_key_exists('serieBacc', $candidate)){
                $dataPrime[$i]['Serie Bac'] = $candidate['serieBacc'];
            }

            if(array_key_exists('anneeBacc', $candidate)){
                $dataPrime[$i]['Annee du Bac'] = $candidate['anneeBacc'];
            }

            if(array_key_exists('mentionBacc', $candidate)){
                $dataPrime[$i]['Mention du Bac'] = $candidate['mentionBacc'];
            }

            if(array_key_exists('etablissement', $candidate)){
                $dataPrime[$i]['Etablissement'] = $candidate['etablissement'];
            }


            if(array_key_exists('parcours', $candidate)){
                $dataPrime[$i]['Diplome de Licence'] = $candidate['parcours'];
            }

            if(array_key_exists('universite', $candidate)){
                $dataPrime[$i]['Universite'] = $candidate['universite'];
            }

            if(array_key_exists('email', $candidate)){
                $dataPrime[$i]["Email"] = $candidate['email'];
            }

            if(array_key_exists('situationMat', $candidate)){
                $dataPrime[$i]['Situation Matrimoniale'] = $candidate['situationMat'];
            }

            if(array_key_exists('statut', $candidate)){
                $dataPrime[$i]['Status'] = $candidate['statut'];
            }

            if(array_key_exists('profession', $candidate)){
                $dataPrime[$i]['Profession'] = $candidate['profession'];
            }

            if(array_key_exists('1er', $candidate)){
                $dataPrime[$i]['1er Tranche'] = $candidate['1er'];
                if(is_null($candidate['1er']))
                    $dataPrime[$i]['1er Tranche'] = 0;
            }

            if(array_key_exists('Reference1', $candidate)){
                $dataPrime[$i]['Reference 1er tranche'] = $candidate['Reference1'];
            }

            if(array_key_exists('Date1', $candidate)){
                $dataPrime[$i]['Date 1er Tranche'] = $candidate['Date1'];
                if(is_null($candidate['Date1']))
                    $dataPrime[$i]['Date 1er Tranche'] = 0;
            }

            if(array_key_exists('2em', $candidate)){
                $dataPrime[$i]['2em Tranche'] = $candidate['2em'];
                if(is_null($candidate['2em']))
                    $dataPrime[$i]['2em Tranche'] = 0;
            }

            if(array_key_exists('Reference2', $candidate)){
                $dataPrime[$i]['Reference 2em tranche'] = $candidate['Reference2'];
            }

            if(array_key_exists('Date2', $candidate)){
                $dataPrime[$i]['Date 2em Tranche'] = $candidate['Date2'];
                if(is_null($candidate['Date2']))
                    $dataPrime[$i]['Date 2em Tranche'] = "";
            }

            if(array_key_exists('RAD', $candidate)){
                $dataPrime[$i]['Reste à payer'] = $candidate['RAD'];
                if(is_null($candidate['RAD']))
                    $dataPrime[$i]['Reste à payer'] = 0;
            }

            if(array_key_exists('anneeUnivers', $candidate)){
                $dataPrime[$i]['Annee Universitaire'] = $candidate['anneeUnivers'];
            }

            if(array_key_exists('nationalite', $candidate)){
                $dataPrime[$i]['Nationalite'] = $candidate['nationalite'];
                if(is_null($candidate['nationalite']))
                    $dataPrime[$i]['Nationalite'] = 'Malagasy';
            }

            if(array_key_exists('observation', $candidate)){
                $dataPrime[$i]['Observation'] = $candidate['observation'];
            }
            $i++;
        }

        return $dataPrime;
    }

    /**
     * @param Request $request
     * @param $niveau
     * @return Application|RedirectResponse|Redirector|void
     */

    public function exportCandidat(Request $request) {

        $this->request = $request->all();
        $this->request['anneeUnivers'] = 'anneeUnivers';
        $archive = $request['archive'];
        $annee = $request['annee'];

        unset($this->request['niveau']);
        unset($this->request['archive']);
        unset($this->request['annee']);

        if ($archive === "true") {
            switch ($request['niveau']) {
                case "L1":
                    $file_name = "archive-candidat-L1". $annee .".xlsx";
                    $candidates = ArchiveCandidatL1::select(array_splice($this->request, 1))
                        ->where('anneeUnivers', $annee)
                        ->get();
                    break;
                case "M1":
                    $file_name = "archive-candidat-M1". $annee .".xlsx";
                    $candidates = ArchiveCandidatM1::select(array_splice($this->request, 1))
                        ->where('anneeUnivers', $annee)
                        ->get();
                    break;
                case "M2":
                    $file_name = "archive-candidat-M2". $annee .".xlsx";
                    $candidates = ArchiveCandidatM2::select(array_splice($this->request, 1))
                        ->where('anneeUnivers', $annee)
                        ->get();
                    break;
                case "M2-R":
                    $file_name = "archive-candidat-M2-recherche.xlsx";
                    $candidates = CandidatM2R::select(array_splice($this->request, 1))->get();
                    break;

            }
        } else {
            switch ($request['niveau']) {
                case "L1":
                    $file_name = "candidat-L1.xlsx";
                    $candidates = CandidatL::select(array_splice($this->request, 1))->get();
                    break;
                case "M1":
                    $file_name = "candidat-M1.xlsx";
                    $candidates = CandidatM::select(array_splice($this->request, 1))->get();
                    break;
                case "M2":
                    $file_name = "candidat-M2.xlsx";
                    $candidates = CandidatM2::select(array_splice($this->request, 1))->get();
                    break;
                case "M2-R":
                    $file_name = "candidat-M2-recherche.xlsx";
                    $candidates = CandidatM2R::select(array_splice($this->request, 1))->get();
                    break;

            }
        }


        if($candidates->count() > 0){
            $text = "Liste des candidat(e)s préselectionné(e)s ".($candidates->first()->anneeUnivers - 1).'-'.$candidates->first()->anneeUnivers;

            $borderData = new Border(
                new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            );

            $style1 = (new Style())
                ->setFontBold()
                ->setFontSize(13)
                ->setFontColor(Color::WHITE)
                ->setShouldWrapText()
                ->setBackgroundColor(Color::rgb(0, 112, 0))
                ->setBorder($borderData);

            $style2 = (new Style())
                ->setFontSize(11)
                ->setFontColor(Color::BLACK)
                ->setShouldWrapText()
                ->setBorder($borderData);

            if($request->has('idBrdC')){
                $data = $candidates->toArray();
                $data = $this->setValue($data);

                $i = 0;
                foreach ($candidates as $candidate){
                    $data[$i]['Montant'] = number_format($candidate->bordereau->montantBrd1, 0, ',', ' ');
                    $data[$i]['Reference'] = $candidate->bordereau->referenceBrd1;
                    $data[$i]['Date'] = date_format(date_create($candidate->bordereau->dateBrd1), 'd/m/Y');
                    unset($data[$i]['idBrdC']);
                    $i++;
                }


                SimpleExcelWriter::streamDownload($file_name)
                    ->setHeaderStyle($style1)
                    ->addRows($data, $style2)
                    ->addRow([''])
                    ->addRow([$text])
                    ->toBrowser();

            }else {
                $data = $this->setValue($candidates->toArray());

                SimpleExcelWriter::streamDownload($file_name)
                    ->setHeaderStyle($style1)
                    ->addRows($data, $style2)
                    ->addRow([''])
                    ->addRow([$text])
                    ->toBrowser();

            }
        } else {
            // if $candidate is null
            return redirect('export');
        }


    }

    /**
     * @param Request $request
     * @param $niveau
     * @return Application|RedirectResponse|Redirector|void
     */
    public function exportEtudiant(Request $request, $niveau) {

        $this->condition = $request['condition'];
        $this->parcours = $request['parcours'];
        $this->request = $request->all();
        $this->request['anneeUnivers'] = 'anneeUnivers';
        $archive = $request['archive'];
        $annee = $request['annee'];

        unset($this->request['niveau']);
        unset($this->request['condition']);
        unset($this->request['parcours']);
        unset($this->request['archive']);
        unset($this->request['annee']);

        if($archive === "true"){

            switch ($request['niveau']) {
                case "L1":
                    $file_name = "archive-L1";

                    if($this->condition === 'all'){
                        $candidates = ArchiveL1::select(array_splice($this->request, 1))
                            ->where('anneeUnivers', $annee)
                            ->get();
                        $file_name .= "-TOUT";
                    }elseif($this->condition === 'satify'){
                        $candidates = ArchiveL1::select(array_splice($this->request, 1))
                            ->where('anneeUnivers', $annee)
                            ->where('RAD', '<=' , 0)
                            ->get();
                        $file_name .= "-REGLO";
                    }elseif($this->condition === 'insatify'){
                        $candidates = ArchiveL1::select(array_splice($this->request, 1))
                            ->where('anneeUnivers', $annee)
                            ->where('RAD', '>' , 0)
                            ->get();
                        $file_name .= "-NON-REGLO";
                    }
                    $file_name .= ".xlsx";
                    break;

                case "L2":
                    $file_name = "archive-L2";

                    if($this->condition === 'all'){
                        $candidates = ArchiveL2::select(array_splice($this->request, 1))->get();
                        $file_name .= "-TOUT";
                    }elseif($this->condition === 'satify'){
                        $candidates = ArchiveL2::select(array_splice($this->request, 1))
                            ->where('RAD', '<=' , 0)->get();
                        $file_name .= "-REGLO";
                    }elseif($this->condition === 'insatify'){
                        $candidates = ArchiveL2::select(array_splice($this->request, 1))
                            ->where('RAD', '>' , 0)->get();
                        $file_name .= "-NON-REGLO";
                    }
                    $file_name .= ".xlsx";
                    break;

                case "L3":
                    $file_name = "archive-L3";
                    if($this->condition === 'all'){
                        if($this->parcours === "1"){
                            // si education generale
                            $candidates = ArchiveL3::select(array_splice($this->request, 1))
                                ->where('idParcours', 1)
                                ->get();
                            $file_name .= "-TOUT-L3-EG";
                            // si education presco
                        }elseif($this->parcours === "2"){
                            $candidates = ArchiveL3::select(array_splice($this->request, 1))
                                ->where('idParcours', 2)
                                ->get();
                            $file_name .= "-TOUT-L3-PS";
                        }else{
                            $candidates = ArchiveL3::select(array_splice($this->request, 1))->get();
                            $file_name .= "-L3-TOUT";
                        }
                    }elseif($this->condition === 'satify'){
                        // si education generale
                        if($this->parcours === "1"){
                            $candidates = ArchiveL3::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('idParcours', 1)
                                ->get();
                            $file_name .= "-REGLO-EG";
                            // si education presco
                        }elseif($this->parcours === "2"){
                            $candidates = ArchiveL3::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('idParcours', 2)
                                ->get();
                            $file_name .= "-REGLO-PS";
                        }else{
                            $candidates = ArchiveL3::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)->get();
                            $file_name .= "-REGLO";
                        }

                    }elseif($this->condition === 'insatify'){
                        // si education generale
                        if($this->parcours === "1"){
                            $candidates = ArchiveL3::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('idParcours', 1)
                                ->get();
                            $file_name .= "-NON-REGLO-EG";
                            // si education presco
                        }elseif($this->parcours == "2"){
                            $candidates = ArchiveL3::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('idParcours', 2)
                                ->get();
                            $file_name .= "-NON-REGLO-PS";
                        }else{
                            $candidates = ArchiveL3::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)->get();
                            $file_name .= "-NON-REGLO";
                        }

                    }
                    $file_name .= ".xlsx";
                    break;

                case "M1":
                    $file_name = "archive-M1";

                    if($this->condition === 'all'){
                        $file_name .= "-TOUT";
                        $candidates = ArchiveM1::select(array_splice($this->request, 1))->get();
                    }elseif($this->condition === 'satify'){
                        $candidates = ArchiveM1::select(array_splice($this->request, 1))
                            ->where('RAD', '<=' , 0)->get();
                        $file_name .= "-REGLO";
                    }elseif($this->condition === 'insatify'){
                        $candidates = ArchiveM1::select(array_splice($this->request, 1))
                            ->where('RAD', '>' , 0)->get();
                        $file_name .= "-NON-REGLO";
                    }
                    $file_name .= ".xlsx";
                    break;

                case "M2":
                    $file_name = "archive-M2";

                    if($this->condition === 'all'){
                        $file_name .= "-TOUT";
                        $candidates = ArchiveM2::select(array_splice($this->request, 1))->get();
                        // pour l'etudiant complete
                    }elseif($this->condition === 'satify'){
                        $candidates = ArchiveM2::select(array_splice($this->request, 1))
                            ->where('RAD', '<=' , 0)->get();
                        $file_name .= "-REGLO";
                        // pour l'etudiant incomplete
                    }elseif($this->condition === 'insatify'){
                        $candidates = ArchiveM2::select(array_splice($this->request, 1))
                            ->where('RAD', '>' , 0)->get();
                        $file_name .= "-NON-REGLO";
                    }
                    $file_name .= ".xlsx";
                    break;

                case "M2-R":
                    $file_name = "archive-M2-recherche";

                    if($this->condition === 'all'){
                        $file_name .= "-TOUT";

                        if($this->parcours == 'Maths'){
                            $candidates = ArchiveMR::select(array_splice($this->request, 1))
                                ->where('mention', 'Mathématiques')
                                ->get();
                            $file_name .= "-MATHS";
                        }elseif($this->parcours == 'PC'){
                            $candidates = ArchiveMR::select(array_splice($this->request, 1))
                                ->where('mention', "Physique-Chimie")
                                ->get();
                            $file_name .= "-PC";
                        }elseif($this->parcours == 'SE'){
                            $candidates = ArchiveMR::select(array_splice($this->request, 1))
                                ->where('mention', "Science de l'éducation")
                                ->get();
                            $file_name .= "-SE";
                        }else{
                            $candidates = ArchiveMR::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)->get();
                        }

                        // pour l'etudiant complete
                    }elseif($this->condition === 'satify'){
                        $candidates = ArchiveMR::select(array_splice($this->request, 1))
                            ->where('RAD', '<=' , 0)->get();
                        $file_name .= "-REGLO";
                        if($this->parcours == 'Maths'){
                            $candidates = ArchiveMR::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('mention', 'Mathématiques')
                                ->get();
                            $file_name .= "-REGLO-MATHS";
                        }elseif($this->parcours == 'PC'){
                            $candidates = ArchiveMR::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('mention', "Physique-Chimie")
                                ->get();
                            $file_name .= "-REGLO-PC";
                        }elseif($this->parcours == 'SE'){
                            $candidates = ArchiveMR::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('mention', "Science de l'éducation")
                                ->get();
                            $file_name .= "-REGLO-SE";
                        }else{
                            $candidates = ArchiveMR::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)->get();
                        }


                        // pour l'etudiant incomplete
                    }elseif($this->condition === 'insatify'){
                        $candidates = MasterRecherche::select(array_splice($this->request, 1))
                            ->where('RAD', '>' , 0)->get();
                        $file_name .= "-NON-REGLO";

                        if($this->parcours == 'Maths'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('mention', 'Mathématiques')
                                ->get();
                            $file_name .= "-NON-REGLO-MATHS";
                        }elseif($this->parcours == 'PC'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('mention', "Physique-Chimie")
                                ->get();
                            $file_name .= "-NON-REGLO-PC";
                        }elseif($this->parcours == 'SE'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('mention', "Science de l'éducation")
                                ->get();
                            $file_name .= "-NON-REGLO-SE";
                        }else{
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)->get();
                            $file_name .= "-NON-REGLO";
                        }
                    }
                    $file_name .= ".xlsx";
                    break;

            }
        } else {
            switch ($request['niveau']) {
                case "L1":
                    $file_name = "etudiant-L1";

                    if($this->condition === 'all'){
                        $candidates = LicenceOne::select(array_splice($this->request, 1))->get();
                        $file_name .= "-TOUT";
                    }elseif($this->condition === 'satify'){
                        $candidates = LicenceOne::select(array_splice($this->request, 1))
                            ->where('RAD', '<=' , 0)->get();
                        $file_name .= "-REGLO";
                    }elseif($this->condition === 'insatify'){
                        $candidates = LicenceOne::select(array_splice($this->request, 1))
                            ->where('RAD', '>' , 0)->get();
                        $file_name .= "-NON-REGLO";
                    }
                    $file_name .= ".xlsx";
                    break;

                case "L2":
                    $file_name = "etudiant-L2";

                    if($this->condition === 'all'){
                        $candidates = LicenceTwo::select(array_splice($this->request, 1))->get();
                        $file_name .= "-TOUT";
                    }elseif($this->condition === 'satify'){
                        $candidates = LicenceTwo::select(array_splice($this->request, 1))
                            ->where('RAD', '<=' , 0)->get();
                        $file_name .= "-REGLO";
                    }elseif($this->condition === 'insatify'){
                        $candidates = LicenceTwo::select(array_splice($this->request, 1))
                            ->where('RAD', '>' , 0)->get();
                        $file_name .= "-NON-REGLO";
                    }
                    $file_name .= ".xlsx";
                    break;

                case "L3":
                    $file_name = "etudiant-L3";
                    if($this->condition === 'all'){
                        if($this->parcours === "1"){
                            // si education generale
                            $candidates = LicenceThree::select(array_splice($this->request, 1))
                                ->where('idParcours', 1)
                                ->get();
                            $file_name .= "-TOUT-L3-EG";
                            // si education presco
                        }elseif($this->parcours === "2"){
                            $candidates = LicenceThree::select(array_splice($this->request, 1))
                                ->where('idParcours', 2)
                                ->get();
                            $file_name .= "-TOUT-L3-PS";
                        }else{
                            $candidates = LicenceThree::select(array_splice($this->request, 1))->get();
                            $file_name .= "-L3-TOUT";
                        }
                    }elseif($this->condition === 'satify'){
                        // si education generale
                        if($this->parcours === "1"){
                            $candidates = LicenceThree::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('idParcours', 1)
                                ->get();
                            $file_name .= "-REGLO-EG";
                            // si education presco
                        }elseif($this->parcours === "2"){
                            $candidates = LicenceThree::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('idParcours', 2)
                                ->get();
                            $file_name .= "-REGLO-PS";
                        }else{
                            $candidates = LicenceThree::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)->get();
                            $file_name .= "-REGLO";
                        }

                    }elseif($this->condition === 'insatify'){
                        // si education generale
                        if($this->parcours === "1"){
                            $candidates = LicenceThree::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('idParcours', 1)
                                ->get();
                            $file_name .= "-NON-REGLO-EG";
                            // si education presco
                        }elseif($this->parcours == "2"){
                            $candidates = LicenceThree::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('idParcours', 2)
                                ->get();
                            $file_name .= "-NON-REGLO-PS";
                        }else{
                            $candidates = LicenceThree::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)->get();
                            $file_name .= "-NON-REGLO";
                        }

                    }
                    $file_name .= ".xlsx";
                    break;

                case "M1":
                    $file_name = "etudiant-M1";

                    if($this->condition === 'all'){
                        $file_name .= "-TOUT";
                        $candidates = MasterOne::select(array_splice($this->request, 1))->get();
                    }elseif($this->condition === 'satify'){
                        $candidates = MasterOne::select(array_splice($this->request, 1))
                            ->where('RAD', '<=' , 0)->get();
                        $file_name .= "-REGLO";
                    }elseif($this->condition === 'insatify'){
                        $candidates = MasterOne::select(array_splice($this->request, 1))
                            ->where('RAD', '>' , 0)->get();
                        $file_name .= "-NON-REGLO";
                    }
                    $file_name .= ".xlsx";
                    break;

                case "M2":
                    $file_name = "etudiant-M2";

                    if($this->condition === 'all'){
                        $file_name .= "-TOUT";
                        $candidates = MasterTwo::select(array_splice($this->request, 1))->get();
                        // pour l'etudiant complete
                    }elseif($this->condition === 'satify'){
                        $candidates = MasterTwo::select(array_splice($this->request, 1))
                            ->where('RAD', '<=' , 0)->get();
                        $file_name .= "-REGLO";
                        // pour l'etudiant incomplete
                    }elseif($this->condition === 'insatify'){
                        $candidates = MasterTwo::select(array_splice($this->request, 1))
                            ->where('RAD', '>' , 0)->get();
                        $file_name .= "-NON-REGLO";
                    }
                    $file_name .= ".xlsx";
                    break;

                case "M2-R":
                    $file_name = "etudiant-M2-recherche";

                    if($this->condition === 'all'){
                        $file_name .= "-TOUT";

                        if($this->parcours == 'Tout') {
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->get();
                            $file_name .= "-ALL";
                        }elseif($this->parcours == 'Maths'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('mention', 'Mathematique')
                                ->get();
                            $file_name .= "-MATHS";
                        }elseif($this->parcours == 'PC'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('mention', "Physique-Chimie")
                                ->get();
                            $file_name .= "-PC";
                        }elseif($this->parcours == 'SE'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('mention', "Science de l'éducation")
                                ->get();
                            $file_name .= "-SE";
                        }else{
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)->get();
                        }

                        // pour l'etudiant complete
                    }elseif($this->condition === 'satify'){
                        $candidates = MasterRecherche::select(array_splice($this->request, 1))
                            ->where('RAD', '<=' , 0)->get();
                        $file_name .= "-REGLO";
                        if($this->parcours == 'Tout') {
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '<=', 0)
                                ->get();
                            $file_name .= "-ALL";
                        }elseif($this->parcours == 'Maths'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('mention', 'Mathématiques')
                                ->get();
                            $file_name .= "-REGLO-MATHS";
                        }elseif($this->parcours == 'PC'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('mention', "Physique-Chimie")
                                ->get();
                            $file_name .= "-REGLO-PC";
                        }elseif($this->parcours == 'SE'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)
                                ->where('mention', "Science de l'éducation")
                                ->get();
                            $file_name .= "-REGLO-SE";
                        }else{
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '<=' , 0)->get();
                        }


                        // pour l'etudiant incomplete
                    }elseif($this->condition === 'insatify'){
                        $candidates = MasterRecherche::select(array_splice($this->request, 1))
                            ->where('RAD', '>' , 0)->get();
                        $file_name .= "-NON-REGLO";
                        if($this->parcours == 'Tout') {
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '>', 0)
                                ->get();
                            $file_name .= "-ALL";
                        }elseif($this->parcours == 'Maths'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('mention', 'Mathématiques')
                                ->get();
                            $file_name .= "-NON-REGLO-MATHS";
                        }elseif($this->parcours == 'PC'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('mention', "Physique-Chimie")
                                ->get();
                            $file_name .= "-NON-REGLO-PC";
                        }elseif($this->parcours == 'SE'){
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)
                                ->where('mention', "Science de l'éducation")
                                ->get();
                            $file_name .= "-NON-REGLO-SE";
                        }else{
                            $candidates = MasterRecherche::select(array_splice($this->request, 1))
                                ->where('RAD', '>' , 0)->get();
                            $file_name .= "-NON-REGLO";
                        }
                    }
                    $file_name .= ".xlsx";
                    break;

            }
        }

        $candidates = $candidates->sortBy('numInscrit');

        if($candidates->count() > 0){
            $dataPrime = $this->setValue($candidates->toArray());

            $text = "Liste des etudiant(e)s inscrit(e)s ".$niveau." : ".($candidates->first()->anneeUnivers - 1).'-'.$candidates->first()->anneeUnivers;

            $borderData = new Border(
                new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            );

            $style1 = (new Style())
                ->setFontBold()
                ->setFontSize(13)
                ->setFontColor(Color::WHITE)
                ->setShouldWrapText()
                ->setBackgroundColor(Color::rgb(0, 112, 0))
                ->setBorder($borderData);

            $style2 = (new Style())
                ->setFontSize(11)
                ->setFontColor(Color::BLACK)
                ->setShouldWrapText()
                ->setBorder($borderData);


            if($request->has('idBrdE')){;
                $dataSecond = $candidates->toArray();


                $i = 0;
                foreach ($candidates as $candidate){
                    $dataSecond[$i]['1er'] = number_format($candidate->bordereau->montantBrd1, 0, ',', ' ');
                    if(is_null($candidate->bordereau->referenceBrd1)){
                        $dataSecond[$i]['Reference1'] = "Aucune";
                        $dataSecond[$i]['Reference1'] = "Aucune";
                        $dataSecond[$i]['Date1'] = "Aucune";
                    }else{
//                        $date1 = date_format(date_create($candidate->bordereau->dateBrd1), 'd/m/Y');
//                        $dataSecond[$i]['Reference1'] = $candidate->bordereau->referenceBrd1." du ".$date1;
                        $date1 = date_format(date_create($candidate->bordereau->dateBrd1), 'd/m/Y');
                        $dataSecond[$i]['Reference1'] = $candidate->bordereau->referenceBrd1;
                        $dataSecond[$i]['Date1'] = $date1;
                    }


                    $dataSecond[$i]['2em'] = number_format($candidate->bordereau->montantBrd2, 0, ',', ' ');
                    if(is_null($candidate->bordereau->referenceBrd2)){
                        $dataSecond[$i]['Reference2'] = "Aucune";
                        $dataSecond[$i]['Reference2'] = "Aucune";
                        $dataSecond[$i]['Date2'] = "Aucune";
                    }else{
//                        $date2 = date_format(date_create($candidate->bordereau->dateBrd2), 'd/m/Y');
//                        $dataSecond[$i]['Reference2'] = $candidate->bordereau->referenceBrd2." du ".$date2;
                        $date2 = date_format(date_create($candidate->bordereau->dateBrd2), 'd/m/Y');
                        $dataSecond[$i]['Reference2'] = $candidate->bordereau->referenceBrd2;
                        $dataSecond[$i]['Date2'] = $date2;
                    }

                    unset($dataSecond[$i]['idBrdE']);
                    $i++;
                }


                $dataSecond = $this->setValue($dataSecond);

                SimpleExcelWriter::streamDownload($file_name)
                    ->setHeaderStyle($style1)
                    ->addRows($dataSecond, $style2)
                    ->addRow([''])
                    ->addRow([$text])
                    ->toBrowser();

            }else {

                SimpleExcelWriter::streamDownload($file_name)
                    ->setHeaderStyle($style1)
                    ->addRows($dataPrime, $style2)
                    ->addRow([''])
                    ->addRow([$text])
                    ->toBrowser();

            }
        } else {
            // if $candidate is null
            return redirect('export');
        }


    }

    public function exportModel(Request $request, $niveau){
        $borderData = new Border(
            new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
        );

        $style1 = (new Style())
            ->setFontBold()
            ->setFontSize(13)
            ->setFontColor(Color::WHITE)
            ->setShouldWrapText()
            ->setBackgroundColor(Color::rgb(0, 112, 0))
            ->setBorder($borderData);

        if($request->has('type')){
            $data = array();
            $file_name = "";
            $type = $request['type'];
            switch ($type) {
                case "admis":
                    $file_name = "model-admis.xlsx";
                    $data = [['Numero'=> "", 'Nom'=> "", 'Prenoms'=> ""]];
                    break;
                case "preselection":
                    if($niveau === 'L1')
                        $data = [['Nom'=>"", 'Prenoms'=>"", 'Date de Naissance'=>"", 'Lieu de Naissance'=>"",'Telephone'=>"",
                            'CIN'=>"", 'Nationalite'=>"", 'Annee Universitaire'=>"",'Genre'=>"", 'Serie Bac'=>"", 'Annee du Bac'=>"",
                            'Mention du Bac'=>"", 'Montant'=>"", 'Reference'=>"", 'Date'=>"", 'Observation'=>""]];
                    elseif ($niveau === 'M1' or $niveau === 'M2')
                        $data = [['Nom'=>"", 'Prenoms'=>"", 'Date de Naissance'=>"", 'Lieu de Naissance'=>"",'Telephone'=>"",
                            'CIN'=>"", 'Email'=>"", 'Nationalite'=>"", 'Status'=>"" ,'Annee Universitaire'=>"",'Genre'=>"",'Diplome de Licence'=>"", 'Etablissement'=>"",
                            'Universite'=>"", "Centre d'examen"=>"", 'Profession' =>"",'Situation Matrimoniale'=>"",
                            'Montant'=>"" ,'Reference'=>"", 'Date'=>"", 'Observation'=>""]];
                    elseif ($niveau === 'M2R')
                        $data = [['Nom'=>"", 'Prenoms'=>"", 'Date de Naissance'=>"", 'Lieu de Naissance'=>"",'Telephone'=>"",
                            'CIN'=>'', 'Email'=>'', 'Nationalite'=>'', 'Status'=>'' ,'Annee Universitaire'=>'','Genre'=>'','Cursus'=>'', 'Etablissement'=>'',
                            'Universite'=>"", 'Profession'=>"" ,'Situation Matrimoniale'=>"",
                            'Montant' =>"",'Reference'=>"", 'Date'=>"", 'Observation'=>""]];
                    $file_name = "model-preselection-".$niveau.".xlsx";

                    break;
                case "note":
                    if($request['parcours'] != ""){
                        $data = [UniteEnseignement::select('matiere')
                            ->join('element_constitutifs', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                            ->where('niveau', '=', $niveau)
                            ->where('parcours', '=', $request['parcours'])
                            ->where('unite_enseignements.statut', '=', '1')
                            ->get()->toArray()];
                    }else{
                        $data = [UniteEnseignement::select('matiere')
                            ->join('element_constitutifs', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                            ->where('niveau', '=', $niveau)
                            ->where('unite_enseignements.statut', '=', '1')
                            ->get()->toArray()];
                    }

                    $file_name = "model-note-".$niveau.".xlsx";
                    $newData = [['Numero'=> "", 'Nom'=> "", 'Prenoms'=> ""]];
                    $i = 3;
                    foreach ($data[0] as $d){
                        $newData[0][$d['matiere']] = "";
                        $i++;
                    }

                    $data = $newData;
                    break;

                case "archive":
                    $file_name = "model-archive-".$niveau.".xlsx";
                    $data = [['Numero'=>"", 'Nom'=>"", 'Prenoms'=>"", 'Date de Naissance'=>"", 'Lieu de Naissance'=>"",'Telephone'=>"",
                            'CIN'=>"", 'Nationalite'=>"", 'Genre'=>"", 'Centre d\'examen'=>"", 'Email'=>"",
                            'Situation matrimoniale'=>"", 'Profession'=>"", 'Status'=>"", 'Reference 1ere tranche'=>"", 'Montant 1ere tranche'=>"",
                            'Date 1ere tranche'=>"", 'Reference 2eme tranche'=>"", 'Montant 2eme tranche'=>"",
                            'Date 2eme tranche'=>"", 'Reste à payer'=>"", 'Observation'=>""]];
                    if ($niveau === 'L3')
                        $data = [['Numero'=>"", 'Nom'=>"", 'Prenoms'=>"", 'Options'=>"", 'Date de Naissance'=>"", 'Lieu de Naissance'=>"",'Telephone'=>"",
                            'CIN'=>"", 'Nationalite'=>"", 'Genre'=>"", 'Centre d\'examen'=>"", 'Email'=>"",
                            'Situation matrimoniale'=>"", 'Profession'=>"", 'Status'=>"", 'Reference 1ere tranche'=>"", 'Montant 1ere tranche'=>"",
                            'Date 1ere tranche'=>"", 'Reference 2eme tranche'=>"", 'Montant 2eme tranche'=>"",
                            'Date 2eme tranche'=>"", 'Reste à payer'=>"", 'Observation'=>""]];
                    break;

                case "listStd":
                    $file_name = "model-liste-".$niveau.".xlsx";
                    $data = [['Nom'=>"", 'Prenoms'=>"", 'Date de Naissance'=>"", 'Lieu de Naissance'=>"",'Telephone'=>"",
                        'CIN'=>"", 'Nationalite'=>"", 'Genre'=>"", 'Centre d\'examen'=>"", 'Email'=>"",
                        'Situation matrimoniale'=>"", 'Profession'=>"", 'Status'=>"", 'Annee Universitaire'=>"", 'Reference 1ere tranche'=>"", 'Montant 1ere tranche'=>"",
                        'Date 1ere tranche'=>"", 'Reference 2eme tranche'=>"", 'Montant 2eme tranche'=>"",
                        'Date 2eme tranche'=>"", 'Reste à payer'=>"", 'Observation'=>""]];
                    if ($niveau === 'L3')
                        $data = [['Nom'=>"", 'Prenoms'=>"", 'Options'=>"", 'Date de Naissance'=>"", 'Lieu de Naissance'=>"",'Telephone'=>"",
                            'CIN'=>"", 'Nationalite'=>"", 'Genre'=>"", 'Centre d\'examen'=>"", 'Email'=>"",
                            'Situation matrimoniale'=>"", 'Profession'=>"", 'Status'=>"", 'Annee Universitaire'=>"", 'Reference 1ere tranche'=>"", 'Montant 1ere tranche'=>"",
                            'Date 1ere tranche'=>"", 'Reference 2eme tranche'=>"", 'Montant 2eme tranche'=>"",
                            'Date 2eme tranche'=>"", 'Reste à payer'=>"", 'Observation'=>""]];
                    if ($niveau === 'M2R')
                        $data = [['Nom'=>"", 'Prenoms'=>"", 'Date de Naissance'=>"", 'Lieu de Naissance'=>"",'Telephone'=>"",
                            'CIN'=>"", 'Nationalite'=>"", 'Genre'=>"", 'Email'=>"", 'Mention'=>"",
                            'Situation matrimoniale'=>"", 'Profession'=>"", 'Status'=>"", 'Annee Universitaire'=>"", 'Reference 1ere tranche'=>"", 'Montant 1ere tranche'=>"",
                            'Date 1ere tranche'=>"", 'Reference 2eme tranche'=>"", 'Montant 2eme tranche'=>"",
                            'Date 2eme tranche'=>"", 'Reste à payer'=>"", 'Observation'=>""]];
                    break;
    }

            SimpleExcelWriter::streamDownload($file_name)
                ->setHeaderStyle($style1)
                ->addRows($data, $style1)
                ->toBrowser();
        }
        else{
            return redirect()->back();
        }
    }

    private function checkNoteValidation($tableau, $noteEliminatoire) {
        foreach ($tableau as $nombre) {
            if ($nombre < $noteEliminatoire) {
                return true;
            }
        }
        return false;
    }

    private function  calculMoyenne($dividende, $diviseur) {
        if ($diviseur != 0) {
            $resultat = $dividende / $diviseur;
            return round($resultat, 2);
        } else {
            return "Division par zéro impossible.";
        }
    }

    private function checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC)
    {
        if (count($ECArray) !== $countEC)
            return 'NON CLASSE';
        if ($this->checkNoteValidation ($ECArray, 5))
            return 'NON VALIDE';
        if (($totalEC / $totalPoidsEC) < 10)
            return 'NON VALIDE';
        return 'VALIDE';
    }

    private function checkDecision($UEState, $resultType)
    {
        if (in_array('NON CLASSE', $UEState))
            return 'NON CLASSE';
        if (in_array('NON VALIDE', $UEState)) {
            if ($resultType === 'noteSN')
                return '2e SESSION';
            else
                return 'NON ADMIS';
        }
        return 'ADMIS';
    }

    private function exportNoteL1(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $count = LicenceOne::count();
        $startId = LicenceOne::first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'L1')
            ->where('statut', 1)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = LicenceOne::with('note', 'note.note', 'note.matiere')
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteL2(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $count = LicenceTwo::count();
        $startId = LicenceTwo::first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'L2')
            ->where('statut', 1)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = LicenceTwo::with('note', 'note.note', 'note.matiere')
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteL3(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $count = LicenceThree::count();
        $startId = LicenceThree::first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'L3')
            ->where('statut', 1)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = LicenceThree::with('note', 'note.note', 'note.matiere')
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteM1(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $count = MasterOne::count();
        $startId = MasterOne::first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'M1')
            ->where('statut', 1)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = MasterOne::with('note', 'note.note', 'note.matiere')
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteM2(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $count = MasterTwo::count();
        $startId = MasterTwo::first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'M2')
            ->where('statut', 1)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = MasterTwo::with('note', 'note.note', 'note.matiere')
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteMR(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $count = MasterRecherche::count();
        $startId = MasterRecherche::first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'MR')
            ->where('statut', 1)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = MasterRecherche::with('note', 'note.note', 'note.matiere')
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteArchiveL1(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $annee = $request['annee'];
        $count = ArchiveL1::where('anneeUnivers', '=', $annee)->count();
        $startId = ArchiveL1::where('anneeUnivers', '=', $annee)->first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'L1')
            ->where('anneeUnivers', '=', $annee)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = ArchiveL1::with('note', 'note.note', 'note.matiere')
                ->where('anneeUnivers', '=', $annee)
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteArchiveL2(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $annee = $request['annee'];
        $count = ArchiveL2::where('anneeUnivers', '=', $annee)->count();
        $startId = ArchiveL2::where('anneeUnivers', '=', $annee)->first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'L2')
            ->where('anneeUnivers', '=', $annee)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = ArchiveL2::with('note', 'note.note', 'note.matiere')
                ->where('anneeUnivers', '=', $annee)
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    // mila amboarina
    private function exportNoteArchiveL3(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $annee = $request['annee'];
        $count = ArchiveL3::where('anneeUnivers', '=', $annee)->count();
        $startId = ArchiveL3::where('anneeUnivers', '=', $annee)->first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'L3')
            ->where('anneeUnivers', '=', $annee)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = ArchiveL3::with('note', 'note.note', 'note.matiere')
                ->where('anneeUnivers', '=', $annee)
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteArchiveM1(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $annee = $request['annee'];
        $count = ArchiveM1::where('anneeUnivers', '=', $annee)->count();
        $startId = ArchiveM1::where('anneeUnivers', '=', $annee)->first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'M1')
            ->where('anneeUnivers', '=', $annee)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = ArchiveM1::with('note', 'note.note', 'note.matiere')
                ->where('anneeUnivers', '=', $annee)
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteArchiveM2(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $annee = $request['annee'];
        $count = ArchiveM2::where('anneeUnivers', '=', $annee)->count();
        $startId = ArchiveM2::where('anneeUnivers', '=', $annee)->first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'M2')
            ->where('anneeUnivers', '=', $annee)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = ArchiveM2::with('note', 'note.note', 'note.matiere')
                ->where('anneeUnivers', '=', $annee)
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    private function exportNoteArchiveMR(Request $request)
    {
        $i = 0;
        $limitValue = 20;
        $data = array();
        $annee = $request['annee'];
        $count = ArchiveMR::where('anneeUnivers', '=', $annee)->count();
        $startId = ArchiveMR::where('anneeUnivers', '=', $annee)->first()->idEtd;
        $allUE = UniteEnseignement::with ('element')
            ->where('niveau', 'MR')
            ->where('anneeUnivers', '=', $annee)->get();

        for ($j = 0; $j < floor($count / $limitValue) + 1; $j++) {
            $student = ArchiveMR::with('note', 'note.note', 'note.matiere')
                ->where('anneeUnivers', '=', $annee)
                ->where ('idEtd', '>=', $startId)
                ->limit($limitValue)->get();

            foreach ($student as $std) {
                $data[$i]['Numero'] = $std->numInscrit;
                $data[$i]['Nom'] = $std->nom;
                $data[$i]['Prenoms'] = $std->prenom;
                $totalUE = 0;
                $totalCoefUE = 0;
                $UEState = array();

                foreach ($allUE as $UE) {
                    $totalPoidsEC = $UE->credit;
                    $totalEC = 0;
                    $ECArray = array();
                    $countEC = 0;

                    foreach ($UE->element as $matiere) {
                        $countEC += 1;
                        if ($std->note) {
                            try {
                                if ($std->note) {
                                    $note = $std->note->where('idMatiereN', $matiere->idMatiere)->first();
                                    if ($note) {
                                        $noteHeld = ( $request['typeNote'] === 'noteSN' ) ? $note->note->noteSN : ( ( $request['typeNote'] === 'noteSR' ) ? $note->note->noteSR : max ( $note->note->noteSN, $note->note->noteSR ) );
                                        $data[$i][$matiere->matiere] = $noteHeld;
                                        $totalEC += ($noteHeld * $matiere->poids);
                                        $ECArray[] = $noteHeld;
                                    } else {
                                        $data[$i][$matiere->matiere] = '';
                                    }
                                }
                            } catch (\Exception $e){
                                report($e);
                            }
                        }
                    }
                    $status = $this->checkUEValidation ($ECArray, $totalEC, $totalPoidsEC, $countEC);
                    $UEState[] = $status;
                    $data[$i]['Status UE '. $UE->designation] = $status;
                    $totalUE += ($this->calculMoyenne($totalEC, $totalPoidsEC) * $UE->credit);
                    $totalCoefUE += $UE->credit;
                }
                $data[$i]['Moyenne générale'] = $this->calculMoyenne ($totalUE, $totalCoefUE);
                $data[$i]['DECISION'] = $this->checkDecision ($UEState, $request['typeNote']);
                $data[$i]['Reste à payer'] = $std->RAD;
                $startId = $std->idEtd + 1;
                $i++;
            }
            $i++;
        }
        return $data;
    }

    /**
     * @param Request $request
     * @param $niveau
     * @return Application|RedirectResponse|Redirector|void
     */
    public function exportNote(Request $request, $niveau){
        // get annee Universitaire courante
        try {
            if($request['archive'] === "true"){
                $annee = $request['annee'];
                switch ($request['niveau']) {
                    case "L1":
                        $file_name = "note-L1-".$request['typeNote']."-".$annee.".xlsx";
//                        $students = ArchiveL1::with('note', 'note.note', 'note.matiere')
//                            ->where('anneeUnivers', '=', $annee)
//                            ->orderBy('numInscrit')
//                            ->get();
//                        $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
//                            ->where ('unite_enseignements.niveau', $request['niveau'])
//                            ->where ('element_constitutifs.statut', 1)
//                            ->get ();
                        $data = $this->exportNoteArchiveL1($request);
                        break;

                    case "L2":
                        $file_name = "note-L2-".$request['typeNote']."-".$annee.".xlsx";
//                        $students = ArchiveL2::with('note', 'note.note', 'note.matiere')
//                            ->where('anneeUnivers', '=', $annee)
//                            ->orderBy('numInscrit')
//                            ->get();
//                        $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
//                            ->where ('unite_enseignements.niveau', $request['niveau'])
//                            ->where ('element_constitutifs.statut', 1)
//                            ->get ();
                        $data = $this->exportNoteArchiveL2($request);
                        break;

                    case "L3":
                        $file_name = "note-L3-".$request['typeNote']."-".$annee;

                        if($this->parcours == '1'){
                            $students = ArchiveL3::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('idParcours', 1)
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-EG";

                            // si education presco
                        }elseif($this->parcours == '2'){
                            $students = ArchiveL3::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('idParcours', 2)
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-PS";
                        }else{
                            $students = ArchiveL3::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                        }

                        $file_name .= ".xlsx";
                        break;

                    case "M1":
                        $file_name = "note-M1-".$request['typeNote']."-".$annee.".xlsx";
//                        $students = ArchiveM1::with('note', 'note.note', 'note.matiere')
//                            ->where('anneeUnivers', '=', $annee)
//                            ->orderBy('numInscrit')
//                            ->get();
//                        $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
//                            ->where ('unite_enseignements.niveau', $request['niveau'])
//                            ->where ('element_constitutifs.statut', 1)
//                            ->get ();
                        $data = $this->exportNoteArchiveM1($request);
                        break;

                    case "M2":
                        $file_name = "note-M2-".$request['typeNote']."-".$annee.".xlsx";
//                        $students = ArchiveM2::with('note', 'note.note', 'note.matiere')
//                            ->where('anneeUnivers', '=', $annee)
//                            ->orderBy('numInscrit')
//                            ->get();
//                        $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
//                            ->where ('unite_enseignements.niveau', $request['niveau'])
//                            ->where ('element_constitutifs.statut', 1)
//                            ->get ();
                        $data = $this->exportNoteArchiveM2($request);
                        break;

                    case "M2-R":
                        $file_name = "note-M2-Recherche-".$request['typeNote']."-".$annee;
                        if($this->parcours == 'Maths'){
                            $students = ArchiveMR::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('mention', 'Mathématiques')
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-Maths";

                        }elseif($this->parcours == 'PC'){
                            $students = ArchiveMR::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('mention', 'Physique-Chimie')
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-PC";

                        }elseif($this->parcours == 'SE'){
                            $students = ArchiveMR::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('mention', "Science de l'éducation")
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-SE";

                        }else{
                            $students = ArchiveMR::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                        }

                        $file_name .= ".xlsx";
                        break;

                }
            }else{
                $annee = LicenceOne::first()->anneeUnivers;
                switch ($request['niveau']) {
                    case "L1":
                        $file_name = "note-L1-".$request['typeNote']."-".$annee.".xlsx";
                        $data = $this->exportNoteL1($request);
                        /*
                        $students = LicenceOne::with('note', 'note.note', 'note.matiere')
                            ->where('anneeUnivers', '=', $annee)
                            ->orderBy('numInscrit')
                            ->get();
                        $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                            ->where ('unite_enseignements.niveau', $request['niveau'])
                            ->where ('element_constitutifs.statut', 1)
                            ->get ();
                        */
                        break;

                    case "L2":
                        $file_name = "note-L2-".$request['typeNote']."-".$annee.".xlsx";
                        $data = $this->exportNoteL2($request);
                        /*
                        $students = LicenceTwo::with('note', 'note.note', 'note.matiere')
                            ->where('anneeUnivers', '=', $annee)
                            ->orderBy('numInscrit')
                            ->get();
                        $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                            ->where ('unite_enseignements.niveau', $request['niveau'])
                            ->where ('element_constitutifs.statut', 1)
                            ->get ();
                        */
                        break;

                    case "L3":
                        $file_name = "note-L3-".$request['typeNote']."-".$annee;

                        if($this->parcours == '1'){
                            $students = LicenceThree::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('idParcours', 1)
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-EG";

                            // si education presco
                        }elseif($this->parcours == '2'){
                            $students = LicenceThree::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('idParcours', 2)
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-PS";
                        }else{
                            $students = LicenceThree::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                        }

                        $file_name .= ".xlsx";
                        break;

                    case "M1":
                        $file_name = "note-M1-".$request['typeNote']."-".$annee.".xlsx";
                        $data = $this->exportNoteM1($request);
                        /*
                        $students = MasterOne::with('note', 'note.note', 'note.matiere')
                            ->where('anneeUnivers', '=', $annee)
                            ->orderBy('numInscrit')
                            ->limit (5)
                            ->get ();
                        $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                            ->where ('unite_enseignements.niveau', $request['niveau'])
                            ->where ('element_constitutifs.statut', 1)
                            ->get ();
                        */
                        break;

                    case "M2":
                        $file_name = "note-M2-".$request['typeNote']."-".$annee.".xlsx";
                        $data = $this->exportNoteM2($request);
                        /*
                        $students = MasterTwo::with('note', 'note.note', 'note.matiere')
                            ->where('anneeUnivers', '=', $annee)
                            ->orderBy('numInscrit')
                            ->get();
                        $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                            ->where ('unite_enseignements.niveau', $request['niveau'])
                            ->where ('element_constitutifs.statut', 1)
                            ->get ();
                        */

                        break;

                    case "M2-R":
                        $file_name = "note-M2-Recherche-".$request['typeNote']."-".$annee;
                        if($this->parcours == 'Maths'){
                            $students = MasterRecherche::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('mention', 'Mathématiques')
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-Maths";

                        }elseif($this->parcours == 'PC'){
                            $students = MasterRecherche::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('mention', 'Physique-Chimie')
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-PC";

                        }elseif($this->parcours == 'SE'){
                            $students = MasterRecherche::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->where('mention', "Science de l'éducation")
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                            $file_name .= "-SE";

                        }else{
                            $students = MasterRecherche::with('note', 'note.note', 'note.matiere')
                                ->where('anneeUnivers', '=', $annee)
                                ->orderBy('numInscrit')
                                ->get();
                            $allMatiere = ElementConstitutif::join('unite_enseignements', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                                ->where ('unite_enseignements.niveau', $request['niveau'])
                                ->where ('element_constitutifs.statut', 1)
                                ->get ();
                        }

                        $file_name .= ".xlsx";
                        break;
                }
            }

                $text = "Note des étudiant(e)s inscrit(e)s ";

                $borderData = new Border(
                    new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                    new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                    new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
                    new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
                );

                $style1 = (new Style())
                    ->setFontBold()
                    ->setFontSize(13)
                    ->setFontColor(Color::WHITE)
                    ->setShouldWrapText()
                    ->setBackgroundColor(Color::rgb(0, 112, 0))
                    ->setBorder($borderData);

                $style2 = (new Style())
                    ->setFontSize(11)
                    ->setFontColor(Color::BLACK)
                    ->setShouldWrapText()
                    ->setBorder($borderData);

                SimpleExcelWriter::streamDownload($file_name)
                    ->setHeaderStyle($style1)
                    ->addRows($data, $style2)
                    ->addRow([''])
                    ->addRow([$text])
                    ->toBrowser();
        } catch (\Exception $e){
            report($e);
            return redirect()->back()->withErrors([
                'export' => 'Une erreur est survenue pendant la generation du fichier Excel.',
            ]);
        }
    }

    private function doExportAttestation(Request $request, $lastAttestation)
    {
        $path = "/images/img.svg";
        $data = [
            'numeroAttestation' => $lastAttestation,
            'nom' => $request['nom'],
            'prenom' => $request['prenom'],
            'dateNaissance' => date_format(date_create($request['dateNaissance']), 'd/m/Y'),
            'dateNow' => $this->formatDateFr(),
            'lieuNaissance' => $request['lieuNaissance'],
            'annee' => $request['anneeUnivers'],
            'numInscrit' => $request['numInscrit'],
            'logo' => "data:image/svg+xml;base64,".base64_encode(file_get_contents(public_path($path))),

        ];

        Attestation::create([
            'numAttestation' => $lastAttestation,
            'nom' => $request['nom'],
            'prenom' => $request['prenom'],
            'dateNaissance' => $request['dateNaissance'],
            'dateDelivrance' => date_create(null),
            'lieuNaissance' => $request['lieuNaissance'],
            'anneeUnivers' => $request['anneeUnivers'],
            'numInscrit' => $request['numInscrit'],
        ]);

        $pdf = PDF::loadView('pdfExport.attestation', $data);
        PDF::setOptions([
            "defaultPaperSize" => "a4",
            "dpi" => 150,
        ]);
        return $pdf->stream($lastAttestation.'-'.$request['nom'].'-'.$request['prenom'].'.pdf');
    }

    public function doExportReleve(Request $request, $lastReleve){
        $releves = [];
        $sumPoids = 0;
        $sumNote = 0;
        $sumNoteMax = 0;
        $mention = "";
        $decision = "ADMIS(E)";
        $niveau = ['L1' => "Premiere année de Licence",
                   'L2' => "Deuxième année de Licence",
                   'L3' => "Troisième année de Licence",
                   'M1' => "Premiere année de Master",
                   'M2' => "Deuxième année de Master",
            ];

        if($request['archive']){
            switch ($request['niveau']){
                case 'L1':
                    $note = ArchiveNoteL1::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('archive_l1_s', 'archive_note_l1_s.idEtdN', '=', 'archive_l1_s.idEtd')
                        ->join('archive_notes', 'archive_notes.idNote', '=', 'archive_note_l1_s.idNote')
                        ->where('archive_l1_s.anneeUnivers', $request['annee'])
                        ->where('archive_l1_s.numInscrit', $request['numInscrit'])
                        ->get()->toArray();
                    break;
                case 'L2':
                    $note = ArchiveNoteL2::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('archive_l2_s', 'archive_note_l2_s.idEtdN', '=', 'archive_l2_s.idEtd')
                        ->join('archive_notes', 'archive_notes.idNote', '=', 'archive_note_l2_s.idNote')
                        ->where('archive_l2_s.anneeUnivers', $request['annee'])
                        ->where('archive_l2_s.numInscrit', $request['numInscrit'])
                        ->get()->toArray();
                    break;
                case 'L3':
                    $note = ArchiveNoteL3::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('archive_l3_s', 'archive_note_l3_s.idEtdN', '=', 'archive_l3_s.idEtd')
                        ->join('archive_notes', 'archive_notes.idNote', '=', 'archive_note_l3_s.idNote')
                        ->where('archive_l3_s.anneeUnivers', $request['annee'])
                        ->where('archive_l3_s.numInscrit', $request['numInscrit'])
                        ->get()->toArray();

                    break;
                case 'M1':
                    $note = ArchiveNoteM1::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('archive_m1_s', 'archive_note_m1_s.idEtdN', '=', 'archive_m1_s.idEtd')
                        ->join('archive_notes', 'archive_notes.idNote', '=', 'archive_note_m1_s.idNote')
                        ->where('archive_m1_s.anneeUnivers', $request['annee'])
                        ->where('archive_m1_s.numInscrit', $request['numInscrit'])
                        ->get()->toArray();
                    break;
                case 'M2':
                    $note = ArchiveNoteM2::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('archive_m2_s', 'archive_note_m2_s.idEtdN', '=', 'archive_m2_s.idEtd')
                        ->join('archive_notes', 'archive_notes.idNote', '=', 'archive_note_m2_s.idNote')
                        ->where('archive_m2_s.anneeUnivers', $request['annee'])
                        ->where('archive_m2_s.numInscrit', $request['numInscrit'])
                        ->get()->toArray();
                    break;
                case 'M2R':
                    $note = ArchiveNoteMRS::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('archive_m_r_s', 'archive_note_m_r_s.idEtdN', '=', 'archive_m_r_s.idEtd')
                        ->join('archive_notes', 'archive_notes.idNote', '=', 'archive_note_m_r_s.idNote')
                        ->where('archive_m_r_s.anneeUnivers', $request['annee'])
                        ->where('archive_m_r_s.numInscrit', $request['numInscrit'])
                        ->get()->toArray();
                    break;

            }
        } else {
            switch ($request['niveau']){
                case 'L1':
                    $note = NoteL1::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('notes', 'notes.idNote', '=', 'note_l1_s.idNote')
                        ->where('numInscrit', '=', $request['numInscrit'])
                        ->get()->toArray();
                    break;
                case 'L2':
                    $note = NoteL2::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('notes', 'notes.idNote', '=', 'note_l2_s.idNote')
                        ->where('numInscrit', '=', $request['numInscrit'])
                        ->get()->toArray();
                    break;
                case 'L3':
                    $note = NoteL3::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('notes', 'notes.idNote', '=', 'note_l3_s.idNote')
                        ->where('numInscrit', '=', $request['numInscrit'])
                        ->get()->toArray();
                    break;
                case 'M1':
                    $note = NoteM1::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('notes', 'notes.idNote', '=', 'note_m1_s.idNote')
                        ->where('numInscrit', '=', $request['numInscrit'])
                        ->get()->toArray();
                    break;
                case 'M2':
                    $note = NoteM2::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('notes', 'notes.idNote', '=', 'note_m2_s.idNote')
                        ->where('numInscrit', '=', $request['numInscrit'])
                        ->get()->toArray();
                case 'M2R':
                    $note = NoteMR::select('idMatiereN', 'noteSN', 'noteSR')
                        ->join('notes', 'notes.idNote', '=', 'note_m_r_s.idNote')
                        ->where('numInscrit', '=', $request['numInscrit'])
                        ->get()->toArray();
                    break;
            }
        }

        if($note){
            // get matière
            if($request['parcours'] != ""){
                $ec = UniteEnseignement::select('idMatiere' ,'matiere', 'poids')
                    ->join('element_constitutifs', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                    ->where('niveau', '=', $request['niveau'])
                    ->where('parcours', '=', $request['parcours'])
                    ->where('unite_enseignements.statut', '=', '1')
                    ->get()->toArray();
            }else{
                $ec = UniteEnseignement::select('matiere', 'poids')
                    ->join('element_constitutifs', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                    ->where('niveau', '=', $request['niveau'])
                    ->where('unite_enseignements.statut', '=', '1')
                    ->get()->toArray();
            }

            $require = 0;
            $i = 0;
            foreach ($ec as $matiere){
                $releves[$i]['matiere'] = $matiere['matiere'];
                $releves[$i]['poids'] = $matiere['poids'];
                $sumPoids += $matiere['poids'];
                foreach ($note as $n ){
                    if($n['idMatiereN'] == $matiere['idMatiere']){
                        $releves[$i]['note'] =max($n['noteSN'], $n['noteSR']) * $matiere['poids'];
                        $sumNote +=  $releves[$i]['note'];
                    }
                }
                // si il y a des notes manquante
                if(!isset($releves[$i]['note'])){
                    $releves[$i]['note'] = "";
                    $require++;
                }


                $releves[$i]['max'] = $matiere['poids'] * 20;
                $sumNoteMax += $matiere['poids'] * 20;
                $i++;
            }

            $moyenne = intval(number_format($sumNote / $sumPoids, 2, ',', ' '));

            if($moyenne < 10 ) {
                $decision = "NON ADMIS(E)";
                $mention = "-";
            }
            elseif ($moyenne > 10 and $moyenne <= 12)
                $mention = "Passable";
            elseif (($moyenne > 12 and $moyenne < 14))
                $mention = "Assez Bien";
            elseif ($moyenne >= 14 and $moyenne < 16 )
                $mention = "Bien";
            elseif ($moyenne >= 16 and $moyenne < 20 )
                $mention = "Très Bien";

            if($require > 0){
                $decision = "NON ADMIS(E)";
                $mention = "";
            }


            $data = [
                'numReleve' => $lastReleve.'/'.date('y'),
                'nom' => $request['nom'],
                'prenom' => $request['prenom'],
                'dateNaissance' => date_format(date_create($request['dateNaissance']), 'd/m/Y'),
                'dateNow' => $this->formatDateFr(),
                'lieuNaissance' => $request['lieuNaissance'],
                'annee' => $request['anneeUnivers'],
                'numInscrit' => $request['numInscrit'],
                'parcours' => $request['parcours'],
                'niveau' => $niveau[$request['niveau']],
                'releves' => json_encode($releves),
                'sumPoids' => $sumPoids,
                'sumNote' => $sumNote,
                'sumNoteMax' => $sumNoteMax,
                'moyenne' => $moyenne,
                'mention' => $mention,
                'decision' => $decision,
            ];

            $releve = Releve::create([
                'numReleve' => $lastReleve,
                'nom' => $request['nom'],
                'prenom' => $request['prenom'],
                'dateNaissance' => $request['dateNaissance'],
                'dateDelivrance' => date_create(null),
                'lieuNaissance' => $request['lieuNaissance'],
                'anneeUnivers' => $request['anneeUnivers'],
                'numInscrit' => $request['numInscrit'],
                'niveau' => $request['niveau'],
                'parcours' => $request['parcours'],
            ]);
            $releve->save();

            $pdf = PDF::loadView('pdfExport.releve', $data);
            PDF::setOptions([
                "defaultPaperSize" => "a4",
                "dpi" => 150,
            ]);
            return $pdf->stream($lastReleve.'-'.$request['nom'].'-'.$request['prenom'].'.pdf');
        } else {
            return redirect(404);
        }


    }

    /**
     * @param $date
     * @param $jour
     * @param $mois
     * @return string
     */
    protected function formatDateFr(): string
    {
        $dates = new DateTime();
        $jour = ['Dimanche' ,'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

        $formattedDate = strftime("%A %d %B %Y", $dates->getTimestamp());
        $day = idate('w', strtotime($formattedDate));
        $month = idate('m', strtotime($formattedDate));
        return $jour[$day] . ' ' . $dates->format('d') . ' ' . $mois[$month - 1] . ' ' . $dates->format('Y');
    }
}

