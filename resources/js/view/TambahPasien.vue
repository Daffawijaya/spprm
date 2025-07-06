<template>
    <Card>
        <template #header> Tambah Pasien </template>
        <template #form>
            <Form :form="form" :onSubmit="kirimData" />
        </template>
    </Card>
</template>

<script>
import Form from "../components/Form.vue";
import Card from "../components/Card.vue";
import { usePasienStore } from "@/stores/pasienStore";

export default {
    components: { Form, Card },
    data() {
        return {
            form: {
                nama: "",
                umur: "",
                jenis_kelamin: "",
                nik: "",
                alamat: "",
                no_telepon: "",
                jenis_pasien: "",
                berlaku_hingga: "",
                poli_asal: "",
                riwayat_medis: "",
            },
            pasienStore: usePasienStore(),
        };
    },
    methods: {
        async kirimData() {
            try {
                const dataKirim = { ...this.form };
                if (dataKirim.jenis_pasien !== "BPJS") {
                    delete dataKirim.berlaku_hingga;
                }

                const res = await this.pasienStore.createPasien(dataKirim);

                // ✅ Tampilkan pesan dari backend
                if (res.message) alert(res.message);

                if (res.id) {
                    this.$router.push({
                        name: "ManajemenPasien",
                        params: { id: res.id },
                    });
                }
            } catch (err) {
                if (err.data?.errors) {
                    const firstError = Object.values(err.data.errors)[0][0];
                    alert(firstError);
                } else if (err.data?.message) {
                    alert(err.data.message);
                } else {
                    alert("Terjadi kesalahan tidak terduga.");
                }
                console.error("Gagal menyimpan:", err);
            }
        },
    },
};
</script>
