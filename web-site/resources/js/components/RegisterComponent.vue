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
                        id="input-3"
                        v-model="form.district"
                        :options="districts"
                        required
                    ></b-form-select>
                </div>
                <div class="col-6">
                    <label class="float-left">Turma *</label>
                    <b-form-select
                        id="input-3"
                        v-model="form.schoolClass"
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
                    <b-form-datepicker id="example-datepicker" v-model="form.birthday"
                                       :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                       :min="form.min" :max="form.max"
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
    mounted() {
        console.log('Register component mounted.')
    },
    data() {
        //min: 1900
        //max: data atual
        const now = new Date()
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())
        return {
            form: {
                name: '',
                email: '',
                password: '',
                district: null,
                schoolClass: null,
                birthday: '',
                max: today,
                min: new Date(1900,1,1)
            },
            districts: [{value: null, text: 'Escolha um distrito'}, 'Pedir à API'],
            schoolClasses: [{value: null, text: 'Escolha uma turma'}, 'Pedir à API'],
        }
    },
    methods: {
        onSubmit(event) {
            event.preventDefault()
            alert(JSON.stringify(this.form))
        },
        redirectToCreateAccount() {
            window.location.href = '/register';
        },
        redirectToRecoverPassword() {
            window.location.href = '/recover';
        }
    }
}
</script>
