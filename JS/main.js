const dataJurusan = {
    "Sains dan Teknologi": ["S1 Teknik Informatika", "S1 Kimia", "S1 Teknik Sipil"],
    "Ekonomi": ["S1 Manajemen Retail", "D3 Perpajakan", "S1 Akuntansi"],
    "Ilmu Sosial" : ["S1 Administrasi Bisnis", "S1 Administrasi Publik", "S1 Hubungan Masyarakat", "S1 Sastra Inggris", "Magister Ilmu Administrasi"],
    "Pertanian" : ["S1 Agribisnis", "S1 Akuakultur"],
    "Hukum": ["S1 Ilmu Hukum"],
    "Kesehatan" : ["D3 Keperawatan", "S1 Keperawatan dan Profesi Ners"],
    "Keguruan dan Ilmu Pendidikan" : ["S1 Pendidikan Teknologi Informasi", "S1 Pendidikan Bahasa Indonesia", "S1 Pendidikan Biologi", "S1 Pendidikan Guru PAUD", "S1 Pendidikan Guru SD", "S1 PJKR", "S1 Pendidikan Matematika"]
};

// Fungsi untuk memperbarui dropdown Program Studi berdasarkan Fakultas
function updateJurusan() {
    const fakultas = document.getElementById("fakultas").value;
    const jurusanDropdown = document.getElementById("jurusan");

    // Kosongkan jurusan lama
    jurusanDropdown.innerHTML = "<option value='' disabled selected>Pilih Program Studi</option>";

    // Tambahkan jurusan sesuai fakultas
    if (fakultas in dataJurusan) {
        dataJurusan[fakultas].forEach(jurusan => {
            const option = document.createElement("option");
            option.value = jurusan;
            option.textContent = jurusan;
            jurusanDropdown.appendChild(option);
        });
    }
}