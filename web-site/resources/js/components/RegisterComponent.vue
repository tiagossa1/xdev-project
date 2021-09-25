<template>
    <div class="mt-4 w-50 text-center m-auto">
        <br>
        <h4 class="mb-4">Criar Conta</h4>
        <b-form @submit="onSubmit">
            <div class="row">
                <div class="col-6">
                    <label class="float-left">Nome *</label>
                    <b-form-input
                        id="input-name"
                        v-model="form.name"
                        name="name"
                        type="text"
                        placeholder="Inserir o nome"
                        required
                    ></b-form-input>
                </div>
                <div class="col-6">
                    <label class="float-left">Email *</label>
                    <b-form-input
                        id="input-email"
                        v-model="form.email"
                        name="email"
                        type="email"
                        placeholder="Inserir o email"
                        required
                    ></b-form-input>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-6">
                    <label class="float-left">Password *</label>
                    <b-form-input
                        id="input-password"
                        v-model="form.password"
                        name="password"
                        placeholder="Inserir password"
                        type="password"
                        required
                    ></b-form-input>
                </div>
                <div class="col-6">
                    <label class="float-left">Confirmar Password</label>
                    <b-form-input
                        id="input-confirm-password"
                        type="password"
                        placeholder="Inserir o password"
                        required
                    ></b-form-input>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-6">
                    <label class="float-left">Distrito *</label>

                    <b-form-select
                        id="input-2"
                        v-model="form.district_id"
                        name="district_id"
                        :options="districts"
                        required
                    ></b-form-select>

                    <!--<select v-model="districts" class="form-control" >
                        <option v-for="district in districts" :value="district.name">
                            {{ district.name }}
                        </option>
                    </select>-->
                </div>
                <div class="col-6">
                    <label class="float-left">Turma *</label>
                    <b-form-select
                        id="input-3"
                        name="school_class_id"
                        v-model="form.school_class_id"
                        :options="schoolClasses"
                        :value="null"
                        required
                    ></b-form-select>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-6">
                    <label class="float-left">Data de nascimento</label>
                    <b-form-datepicker id="example-datepicker" v-model="form.birth_date"
                                       :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                       :min="min" :max="max" name="birth_date"
                                       class="mb-2"></b-form-datepicker>
                </div>
                <div class="col-6">
                </div>
            </div>
            <br>

            <b-button type="submit" class="text-white" variant="primary">Entrar</b-button>
        </b-form>
    </div>
</template>

<script>
export default {
    name: "register-component",
    data() {
        //min: 1900
        //max: data atual
        const now = new Date()
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())
        return {
            districts: [],
            schoolClasses: [],
            max: today,
            min: new Date(1900, 1, 1),
            form: {
                name: '',
                email: '',
                password: '',
                district_id: null,
                school_class_id: null,
                birth_date: '',
                user_type_id: 1,
            },
            //districts: [{value: null, text: 'Escolha um distrito'}, 'Pedir à API'],
            //schoolClasses: [{value: null, text: 'Escolha uma turma'}, 'Pedir à API'],
        }
    },
    mounted() {
        //this.getDistrict();
        console.log('Register component mounted.')
    },
    methods: {
        onSubmit(event) {
            event.preventDefault()
            console.log(JSON.stringify(this.form))
            axios.post('http://127.0.0.1:8001/api/register', this.form)
                .then((response) => {
                    $('#success').html(response.data.message)
                }).catch(err => {
                    console.log(err);
            })


        },
        redirectToCreateAccount() {
            window.location.href = '/register';
        },
        redirectToRecoverPassword() {
            window.location.href = '/recover';
        },
        async getDistrict() {
            let result = await axios.get('http://127.0.0.1:8001/api/districts');
            this.districts = result.data.data.map(x => ({value: x.id, text: x.name}));
            console.log(result.data.data)
        },
        async getSchoolClasses() {
            let res = await axios.get('http://127.0.0.1:8001/api/school-classes');
            this.schoolClasses = res.data.data.map(x => ({value: x.id, text: x.name}));
        }
    },
    created() {
        this.getDistrict();
        this.getSchoolClasses();
    }
}
</script>
