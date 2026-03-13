const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

async function main() {
  const bananaBread = await prisma.product.findFirst({
    where: {
      name: {
        contains: 'Banana Bread'
      }
    }
  });

  if (bananaBread) {
    await prisma.product.update({
      where: { id: bananaBread.id },
      data: { image: '/images/bananabread.jpg' }
    });
    console.log(`Updated image for ${bananaBread.name}`);
  } else {
    console.log('Banana Bread not found');
  }
}

main()
  .catch(console.error)
  .finally(() => prisma.$disconnect());
