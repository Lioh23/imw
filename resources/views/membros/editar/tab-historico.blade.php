<div class="tab-pane fade" id="border-top-historico" role="tabpanel" aria-labelledby="border-top-historico">
   <blockquote class="blockquote">
      <div class="table-responsive">
         <table class="table table-bordered table-striped table-hover mb-4">
             <thead>
                 <tr>
                     <th>DATA</th>
                     <th>OCORRÊNCIA</th>
                     <th>MODO/FORMA</th>
                     <th>IGREJA</th>
                     <th>CONGREGAÇÃO</th>
                     <th>PASTOR</th>
                 </tr>
             </thead>
             <tbody id="historico-tbody">
               @foreach($pessoa->rolPermanente as $rolPermanente)
                  <tr class="{{ $rolPermanente->status == 'A' ? 'tr-green' : ($rolPermanente->status == 'D' ? 'tr-red' : 'tr-red') }}">
                     <td>27/06/2004</td>
                     <td>Recebimento</td>
                     <td>Adesão</td>
                     <td>{{ $rolPermanente->igreja->nome }}</td>
                     <td>-</td>
                     <td>-</td>
                  <tr>
               @endforeach
             </tbody>
         </table>
      </div>
   </blockquote>
</div>