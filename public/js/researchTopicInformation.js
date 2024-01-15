// document.addEventListener("DOMContentLoaded", function() {
//     const btn = document.querySelector('.btn');

//     btn.addEventListener('submit', function (){
//         let studentId = document.querySelector('.idStudent');
//         let subjectId = document.querySelector('.idSubject');
//         let researchTopicId = document.querySelector('.idResearchTopic');
//         const url = '{{ route("studentSubject.store") }}'

//         const data = {
//             idStudent: studentId.value,
//             idSubject: subjectId.value,
//             idResearchTopic: researchTopicId.value,
//         }

//         const configuration = {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify(data),
//         }

//         fetch(url, configuration)
//             .then(response => {
//                 if (!response.ok) {
//                     throw new Error('Network response was not ok');
//                 }
//                 return response.json();
//             })
//             .then(data => {
//                 console.log(data);  // Aquí puedes manejar la respuesta del servidor
//             })
//             .catch(error => {
//                 console.error('Error:', error);
//             });
//     });
// });