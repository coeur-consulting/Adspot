<template>
    <Head title="Welcome" />
    <Navigation />
    <Banner />
    <Sponsors />
    <Categories />

    <Works />
    <Popular/>
    <Contact />
    <Footer />


</template>

<style scoped>

</style>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navigation from '@/Navigation/Header'
import Banner from '@/LandingComponents/Banner'
import Sponsors from '@/LandingComponents/Sponsors'
import Categories from '@/LandingComponents/Categories'

import Works from '@/LandingComponents/Works'
import Popular from '@/LandingComponents/Popular'
import Contact from '@/LandingComponents/Contact'
import Footer from '@/Navigation/Footer'
export default {
    components: {
      Head,
      Link,
      Navigation,
      Banner,
      Sponsors,
      Categories,

      Works,
      Popular,
      Contact,
      Footer

    },
    props: {

    },
}
</script>
