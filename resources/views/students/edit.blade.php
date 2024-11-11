<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Modifier un Étudiant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if(isset($student))

            <div class="modal-body">
                <form action="{{ route('students.update', ['student' => $student->id]) }}" method="POST" id="editStudentForm">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="editStudentId" name="id" />

                    <div class="form-group">
                        <label for="editStudentCIN">CIN</label>
                        <input type="text" class="form-control" id="editStudentCIN" value="{{old('classe',$student->cin)}}"  name="cin" required />
                    </div>

                    <div class="form-group">
                        <label for="editStudentName">Nom</label>
                        <input type="text" class="form-control" id="editStudentName" value="{{old('classe',$student->nom)}}" name="nom" required />
                    </div>

                    <div class="form-group">
                        <label for="editStudentFirstName">Prénom</label>
                        <input type="text" class="form-control" id="editStudentFirstName" value="{{old('classe',$student->prenom)}}" name="prenom" required />
                    </div>

                    <div class="form-group">
                        <label for="editStudentClass">Classe</label>
                        <input type="text" class="form-control" id="editStudentClass" value="{{ old('classe', $student->classe) }}" name="classe" required />
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
                @else
    <p>No student to edit.</p>
@endif
            </div>
        </div>
    </div>
</div>
<script>
function editStudent(student) {
    // Fill form inputs with the student's data
    document.getElementById('editStudentId').value = student.id;
    document.getElementById('editStudentCIN').value = student.cin;
    document.getElementById('editStudentName').value = student.nom;
    document.getElementById('editStudentFirstName').value = student.prenom;
    document.getElementById('editStudentClass').value = student.classe;

    // Update the form action dynamically with the student ID
    const form = document.getElementById('editStudentForm');
    form.action = `/students/${student.id}`; // Make sure the ID is inserted into the URL
    
    // Show the modal
    $('#editStudentModal').modal('show');
}

</script>